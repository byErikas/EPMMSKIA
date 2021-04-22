<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function rateItem(Request $request)
    {
        //rate item from given request
    }

    public function returnItem($slug)
    {
        $item = Product::where('slug', '=', $slug)->first();
        if ($item == null) {
            return redirect('dashboard');
        }

        $rating = $item->ratingsAvg();

        $category = $item->categories->first()->name;
        return view('item')->with([
            'item' => $item,
            'category' => $category,
            'ratings' => $rating
        ]);
    }

    //CRUD FUNCTIONS
    public function index()
    {
        $products = Product::all();
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
            'name' => 'required|unique:products',
            'description' => 'required',
            'price' => 'required|numeric',
            'img_path' => 'required'
        ]);

        $product = Product::find($id);
       // $category = Category::where('product_id', '=', $id)->first();
        $product->name =  $request->get('name');
        $product->slug = Str::slug($request->get('name'));
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->img_path = $request->get('img_path');
        //$category->id = $request->input('category');
        //dd($product->categories->first()->pivot->category_id);
        $product->categories->first()->pivot->category_id = $request->input('category'); //SHIT DONT WORK
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
