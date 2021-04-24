<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Only authenticated users
Route::group(['middleware' => 'auth'], function () {

    Route::get('orders', 'App\Http\Controllers\ProfileController@orders')->name('user.orders');
    //Password change page
    Route::get('change-password', 'App\Http\Controllers\ChangePasswordController@index')->name('index.password');
    Route::post('change-password', 'App\Http\Controllers\ChangePasswordController@store')->name('change.password');

    //Rating
    Route::post('/rate', 'App\Http\Controllers\Api\ProductController@rateItem')->name('rate.item');

    //Profile page routes
    Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile.show');
    Route::patch('/profile', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    });

    //Recommendations page routes
    Route::get('/recommendations', function () {
        return view('recommendations');
    })->name('recommendations');

    //Admin routes
    Route::group(['middleware' => 'admin'], function () {

        //Admin main
        Route::get('/admin', function () {
            return view('admin');
        })->name('admin');

        //CRUDS
        Route::resource('product', 'App\Http\Controllers\ProductController');
        Route::resource('category', 'App\Http\Controllers\CategoryController');
    });
});

//CART ROUTES
Route::get('/', 'App\Http\Controllers\CartController@shop')->name('shop');
Route::get('/dashboard', 'App\Http\Controllers\CartController@shop')->name('dashboard');
Route::get('/checkout', 'App\Http\Controllers\CartController@cart')->name('cart.index');
Route::post('/add', 'App\Http\Controllers\CartController@add')->name('cart.store');
Route::post('/update', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::post('/remove', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
Route::post('/clear', 'App\Http\Controllers\CartController@clear')->name('cart.clear');
Route::post('/update', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::post('/remove', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
//END CART ROUTES

//GLOBAL SHOP ROUTES
Route::get('/categories/{name}', 'App\Http\Controllers\CategoryController@returnCategory')->name('single.category');
Route::get('/categories', 'App\Http\Controllers\CategoryController@allIndex')->name('category.index');
Route::get('/items/{name}', 'App\Http\Controllers\ProductController@returnItem')->name('single.item');
Route::post('/purchase', 'App\Http\Controllers\Api\UserController@purchase')->name('order.purchase');
//END GLOBAL SHOP ROUTES


require __DIR__ . '/auth.php';
