<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function shop()
    {
        //PRODUCT PAGINATION
        $products = Product::paginate(12);

        //PULL MOST PURCHASED ITEMS
        $sql = 'SELECT product_id, SUM(quantity) AS TotalQuantity FROM order_product GROUP BY product_id ORDER BY SUM(quantity) DESC';
        $results = DB::select(DB::raw($sql));
        $top = collect([]);
        $i = 0;
        //FROM ARRAY ID'S TO MODEL COLLECTION
        foreach ($results as $item) {
            $i++;
            if ($i == 9) {
                break;
            }
            $model = Product::find($item->product_id);
            $top->push($model);
        }

        //RETURNS
        return view('dashboard')->with([
            'products' => $products,
            'top' => $top
        ]);
    }

    public function cart()
    {
        $cartCollection = \Cart::getContent();
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = null;
        }
        return view('checkout')->with([
            'cartCollection' => $cartCollection,
            'user' => $user
        ]);
    }

    public function add(Request $request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));
        return redirect()->back()->with('success_msg', 'Item added to cart!');
    }

    public function clear()
    {
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Cart cleared!');
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item removed!');
    }

    public function update(Request $request)
    {
        \Cart::update(
            $request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            )
        );
        return redirect()->route('cart.index')->with('success_msg', 'Cart updated!');
    }
}
