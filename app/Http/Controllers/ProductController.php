<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function rateItem(Request $request)
    {
        $item = Product::find($request->get('id'));
        $item->rateOnce($request->get('rating'));
        return redirect()->back();
    }

    public function userRecommendations()
    {
        $user = Auth::user();
        $output = shell_exec("python /var/www/html/laravel-shop/resources/py/nearest_neighbour.py $user->id 8");
        $output_array = explode("\n", $output);
        $items = collect([]);
        foreach ($output_array as $item)
            if (is_numeric($item) && !empty($item) && !$item == null) {
                $items->add(Product::find($item));
            }
        // dd($items);

        //RETURNS
        return view('recommendations')->with([
            'rating_based' => $items,
        ]);
    }

    public function returnItem($slug)
    {
        //FIND ITEM GIVEN
        $item = Product::where('slug', '=', $slug)->first();
        if ($item == null) {
            return redirect('dashboard');
        }

        //ITEM RATING AND CATEGORY ITEMS
        $rating = $item->averageRating;
        $category = $item->category_id;
        $cat_name = Category::find($category);
        $cat_items = Product::where('category_id', $category)->get();
        $i = 0;
        $dupe = false;
        foreach ($cat_items as $prods) {
            if ($prods->slug == $slug) {
                unset($cat_items[$i]);
                $dupe = true;
            }
            $i++;
        }
        if ($dupe == false) {
            unset($cat_items[count($cat_items) - 1]);
        }

        //CONTENT BASED FILTER - BASED TO ITEM ID
        $output = shell_exec("python /var/www/html/laravel-shop/resources/py/content_based.py $item->id 4");
        // C:/Users/Erikas/eshop/laravel8-shop/public/py/content_based.py
        // /var/www/html/laravel-shop/public/py/content_based.py
        $output_array = explode("\n", $output);
        $similar = collect([]);
        foreach ($output_array as $suggestion) {
            if ($suggestion != null) {
                $similar->add(Product::find($suggestion));
            }
        }
        //END CONTENT BASED FILTER

        $filtered = $cat_items->diff($similar)->take(4);
        //RETURNS
        return view('item')->with([
            'item' => $item,
            'category' => $cat_name->name,
            'ratings' => $rating,
            'similar' => $similar,
            'cat_items' => $filtered,
        ]);
    }

    //CRUD FUNCTIONS
    public function index()
    {
        $products = Product::paginate(3);
        return view('products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('products.edit', compact('product'), compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'img_path' => 'required',
            'category' => 'required',
        ]);

        $product = Product::find($id);
        $product->name =  $request->get('name');
        $product->slug = Str::slug($request->get('name'));
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->img_path = $request->get('img_path');
        $product->category_id = $request->input('category');

        $product->save();

        return redirect('/product')->with('success', 'Produktas atnaujintas!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'img_path' => 'required',
            'category' => 'required',
        ]);

        $product = new Product([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'img_path' => $request->get('img_path'),
            'category_id' => intval($request->input('category')),
        ]);
        $product->save();
        return redirect('/product')->with('success', 'Produktas sukurtas!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/product')->with('success', 'Produktas pašalintas!');
    }
}
