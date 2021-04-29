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

        //PULL MOST PURCHASED ITEMS - END OF $SQL INDICATED COUNT (8)
        $sql = 'select product_id, count(quantity) as c from order_product group by product_id order by c desc limit 8';
        $results = DB::select(DB::raw($sql));
        $top = collect([]);

        //FROM ARRAY ID'S TO MODEL COLLECTION
        foreach ($results as $item) {
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
        return view('checkout')->with(['cartCollection' => $cartCollection]);;
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
