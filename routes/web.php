<?php

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

// Route::get('/index', function () {
//     return view('index');
// });


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::view('/home', 'home')->middleware('auth');

 Route::view('/admin', 'admin')->middleware('auth:admin');
Route::post('/logout/admin', 'Auth\LoginController@logoutAdmin')->name('admin_logout');




 // Route::get('/user/home', 'Controller@ok')->middleware('auth');



Route::get('/', ['as' => 'index', 'uses' => 'UserController@index']);
Route::post('/check-availability', ['as' => 'check_availability', 'uses' => 'UserController@check_availability']);
Route::post('user/book-room', ['as' => 'book_room', 'uses' => 'UserController@book_room'])->middleware('auth');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function()
  {     
  	    Route::get('dashbord', 'AdminController@dashbord');
        Route::match(['get', 'post'],'add-rooms', ['as' => 'add_rooms','uses' =>'AdminController@add_rooms']);
        // Route::get('/bookings', ['as' => 'bookings', 'uses' => 'AdminController@bookings']);
 

  });




