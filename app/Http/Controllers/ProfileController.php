<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        /**
         * fetching the user model
         **/
        $user = Auth::user();
        //var_dump($user);

        /**
         * Passing the user data to profile view
         */
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {

        /**
         * fetching the user model
         */
        $user = Auth::user();


        /**
         * Validate request/input
         **/
        $this->validate($request, [
            'name' => 'required|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        /**
         * storing the input fields name & email in variable $input
         * type array
         **/
        $input = $request->only('name', 'email', 'address', 'city', 'state', 'zip_code');



        /**
         * Accessing the update method and passing in $input array of data
         **/
        $user->update($input);

        /**
         * after everything is done return them pack to /profile/ uri
         **/
        return back();
    }

    public function orders()
    {
        /**
         * fetching the user model
         **/
        $user = Auth::user();
        //var_dump($user);
        $orders = $user->orders;
       // dd($orders);
        /**
         * Passing the user data to profile view
         */
        return view('order')->with(['orders' => $orders]);
    }
}
