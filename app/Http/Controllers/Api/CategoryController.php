<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //Return all categories
        $categories = Category::all();
        return view('categories')->with(['categories' => $categories]);
    }

    public function returnCategory($category)
    {
        //return a requested category if it exists, or redirect
        $model = Category::where('name' , '=', $category)->first();
        if($model == null)
        {
            return redirect('dashboard');
        }
        $products = $model->products;

        return view('category')->with(['products' => $products,
                                       'category' => $model->name]);
    }
}
