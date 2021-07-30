<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class CartController extends Controller
{
    public function shop()
    {
        //PRODUCT PAGINATION
        $products = Product::orderBy('name')->paginate(12);

        //PULL MOST PURCHASED ITEMS
        $sql = 'SELECT product_id FROM order_product GROUP BY product_id ORDER BY SUM(quantity) DESC LIMIT 8';
        $results = DB::select($sql);

        $top_products = collect([]);
        foreach ($results as $row) {
            $id = $row->product_id;
            $model = Product::find($id);
            $top_products->push($model);
        }

        return view('dashboard')->with([
            'products' => $products,
            'top' => $top_products
        ]);
    }

    public function purchase(Request $request)
    {
        if (!Auth::check()) {
            $request->validate([
                'name' => 'required',
                'password' => 'required',
                'email' => 'required|unique:users',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required'
            ]);

            $user = User::firstOrCreate(
                [
                    'email' => $request->input('email'),
                ],
                [
                    'password' => bcrypt($request->input('password')),
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip_code' => $request->input('zip_code')
                ]
            );
            Auth::login($user);
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required'
            ]);
            $user = Auth()->user();
        }
        $transaction_id = Str::random(12);
        $order = $user->orders()
            ->create([
                'transaction_id' => $transaction_id,
                'total' => \Cart::getTotal()
            ]);

        $cart_items = \Cart::getContent();
        foreach ($cart_items as $item) {
            $order->products()->attach($item['id'], ['quantity' => $item->quantity]);
        }

        \Cart::clear();
        return redirect('dashboard')->with('success_msg', 'Užsakymas pateiktas!');
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
        return redirect()->back()->with('success_msg', 'Produktas pridėtas į krepšelį!');
    }

    public function clear()
    {
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Krepšelis išvalytas!');
    }

    public function remove(Request $request)
    {
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Produktas pašalintas!');
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
        return redirect()->route('cart.index')->with('success_msg', 'Krepšelis atnaujintas!');
    }
}
