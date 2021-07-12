<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
        $userId = Auth::id();
        $user = User::findOrFail($userId);

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
        $s_orders = $orders->sortByDesc('created_at');

        return view('order')->with(['orders' => $s_orders]);
    }

    //CRUD FUNCTIONS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
        return redirect('/user')->with('success', 'Vartotojas sukurtas!');
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
        return view('users.edit', compact('user'));
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
        $user->is_admin =  $request->input('is_admin');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->city = $request->get('city');
        $user->state = $request->get('state');
        $user->zip_code = $request->get('zip_code');
        $user->save();

        return redirect('/user')->with('success', 'Vartotojas atnaujintas!');
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

        return redirect('/user')->with('success', 'Vartotojas pašalintas!');
    }
}
