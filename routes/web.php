<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','HomeController@index' );

Auth::routes();
Route::get('/login', 'Web\AppController@getLogin' )->name('login')->middleware('guest');

Route::get( '/login/{social}', 'Web\AuthenticationController@getSocialRedirect' )
    ->middleware('guest');

Route::get( '/login/{social}/callback', 'Web\AuthenticationController@getSocialCallback' )
    ->middleware('guest');

Route::group(['middleware'=>'auth'],function (){
    Route::get('/home', 'HomeController@home')->name('home');

    //Employe Route
    Route::resource('employe','EmployeController');

    //Customer Route
    Route::resource('customer','CustomerController');
});
