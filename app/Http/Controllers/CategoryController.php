<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function allIndex()
    {
        //Return all categories list in categories view
        $categories = Category::all();
        return view('categories')->with(['categories' => $categories]);
    }

    public function returnCategory($category)
    {
        //return a requested category if it exists, or redirect to dashboard
        $category = Category::where('slug', '=', Str::slug($category))->first();
        if ($category == null) {
            return redirect('dashboard');
        }

        $products = Product::where('category_id', $category->id)->get();
        return view('category')->with([
            'products' => $products,
            'category' => $category->name
        ]);
    }

    //CRUD FUNCTIONS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',

        ]);

        $category = new Category([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name')),
        ]);
        $category->save();
        return redirect('/category')->with('success', 'Kategorija sukurta!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);
        $category->name =  $request->get('name');
        $category->slug = Str::slug($request->get('name'));
        $category->save();

        return redirect('/category')->with('success', 'Kategorija atnaujinta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect('/category')->with('success', 'Kategorija pašalinta!');
    }
}
