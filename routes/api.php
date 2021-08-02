<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//l'url ha prefisso /api/nome-rotta
//posso accedere ai file json con funzioni closure, con metodo get (scrivo l'url) o con metodo post(con postman)
//Posso usare anche i controller come per le rotte web.php (php artisan make:controller Api/PostController), sarà lui a gestire i file json

// Anche in questo caso le raggruppo per namespace (cerca nella cartella Api/PostController). Non hanno un metodo name perché non le chiamiamo con un link ma le passiamo con chiamata axios

Route::namespace('Api')
    ->group(function() {

        Route::get('posts', 'PostController@index');
        // rotta show del singlepost
        Route::get('posts/{slug}', 'PostController@show');

    });


