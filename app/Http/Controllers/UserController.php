<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    public function profileIndex()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $input = $request->only('name', 'email', 'address', 'city', 'state', 'zip_code');

        $user->update($input);

        return back();
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders;

        return view('order')->with(['orders' => $orders]);
    }

    public function purchase(Request $request)
    {
        if (!Auth::check()) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
                'address' => 'required|numeric',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required'
            ]);

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
        } else {
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
        return redirect('dashboard')->with('success_msg', 'Order placed!');
    }



    //CRUD FUNCTIONS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users\index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users\create');
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'is_admin' => 'required',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'is_admin' => $request->input('is_admin'),
            'password' => Hash::make($request->get('password')),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'zip_code' => $request->get('zip_code')
        ]);
        $user->save();
        return redirect('/user')->with('success', 'User created!');
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
        $user = User::find($id);
        return view('users\edit', compact('user'));
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
            'email' => 'required|email',
            'is_admin' => 'required'
        ]);

        $user = User::find($id);
        $user->name =  $request->get('name');
        $user->slug = Str::slug($request->get('name'));
        $user->save();

        return redirect('/user')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/user')->with('success', 'User deleted!');
    }
}
