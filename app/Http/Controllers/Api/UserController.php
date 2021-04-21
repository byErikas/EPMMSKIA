<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function purchase(Request $request) {
        if(!Auth::check())
        {
            $user = User::firstOrCreate(
                [
                'email' => $request->input('email'),
                ],
                [
                'password' => Hash::make('password'),
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip_code' => $request->input('zip_code')
                ]
                );
            Auth::login($user);
        }
        else
        {
            $user = Auth()->user();
        }
        $transaction_id = Str::random(12);
        $order = $user->orders()
            ->create([
                'transaction_id' => $transaction_id,
                'total' => \Cart::getTotal()
            ]);

        $cart_items = \Cart::getContent();
        foreach($cart_items as $item) {
            $order->products()->attach($item['id'], ['quantity' => $item->quantity]);
        }

        \Cart::clear();
        return redirect('dashboard')->with('success_msg', 'Order placed!');
    }
}
