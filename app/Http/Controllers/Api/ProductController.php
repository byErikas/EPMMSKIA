<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function index()
    {
        return Product::with('categories:id,name')->get();
    }

    public function returnItem($slug) {
        $item = Product::where('slug', '=', $slug)->first();
        if($item == null)
        {
            return redirect('dashboard');
        }

        $rating = $item->ratingsAvg();

        $category = $item->categories->first()->name;
        return view('item')->with(['item' => $item,
                                    'category' => $category,
                                    'ratings' => $rating]);
    }

    public function rateItem(Request $request){
        //rate item from given request
    }
}
