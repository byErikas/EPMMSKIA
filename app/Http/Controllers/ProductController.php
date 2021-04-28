<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Config;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function rateItem(Request $request)
    {
        $item = Product::find($request->get('id'));
        $item->rateOnce($request->get('rating'));
        return redirect()->back();
    }

    public function returnItem($slug)
    {
        //FIND ITEM GIVEN
        $item = Product::where('slug', '=', $slug)->first();
        if ($item == null) {
            return redirect('dashboard');
        }

        //ITEM RATING AND CATEGORY
        $rating = $item->averageRating;
        $category = $item->categories->first()->name;

        //CONTENT BASED FILTER - BASED TO ITEM ID
        $python_exe = \config('var.python');
        $script = \config('var.content_based');
        $output = shell_exec("$python_exe $script $item->id 5");
        $output_array = explode("\n", $output);
        $similar = collect([]);
        foreach ($output_array as $suggestion) {
            if ($suggestion != null) {
                $similar->add(Product::find($suggestion));
            }
        }
        //END CONTENT BASED FILTER

        //RETURNS
        return view('item')->with([
            'item' => $item,
            'category' => $category,
            'ratings' => $rating,
            'similar' => $similar
        ]);
    }

    //CRUD FUNCTIONS
    public function index()
    {
        $products = Product::paginate(10);
        return view('products\index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('products\edit', compact('product'), compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'img_path' => 'required'
        ]);

        $product = Product::find($id);
        $product->name =  $request->get('name');
        $product->slug = Str::slug($request->get('name'));
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->img_path = $request->get('img_path');
        $product->categories->first()->pivot->category_id = $request->input('category');
        $product->categories->first()->pivot->save();
        $product->save();

        return redirect('/product')->with('success', 'Product updated!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'img_path' => 'required'
        ]);

        $product = new Product([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'img_path' => $request->get('img_path'),
        ]);
        $product->save();
        return redirect('/product')->with('success', 'Product created!');
    }

    public function create()
    {
        return view('products\create');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/product')->with('success', 'Product deleted!');
    }
}
