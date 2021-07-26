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

//rotte per autenticazione
// Auth::routes(["register" => false]); // per disabilitare la registrazione
// Auth::routes(["verify" => true]); // per attivare la verifica mail al momento della registrazione // di default è disabilitata
Auth::routes();

//rotte pubbliche (guest)
// Route::get('/home', 'HomeController@index')->name('home');

 //tutte le rotte protette da autenticazione (admin)
Route::middleware('auth') // autenticazione
    ->namespace('Admin') // controller
    ->name('admin.') // nome rotte
    ->prefix('admin') // url rotte
    ->group(function() {
    
        Route::get('/', 'HomeController@index')->name('home');
        // rotte della crud
        Route::resource('posts', 'PostController');

});

// Rotte pubblicke
// Route::get('/', 'HomeController@index')->name('home');
//Rotta di fallback
Route::get('{any?}', 'HomeController@index')
->where('any', '.*')
->name('home');
