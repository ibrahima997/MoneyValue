<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RatioController;

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

Route::get('/', function () {
    return view('home');
});
Route::get('/converter', function () {
    return view('converter');
});
Route::get('/converter', 'CurrencyController@index');

Auth::routes();
Route::get('/currencies', 'CurrencyController@index');
Route::post('/currencies', 'CurrencyController@add');
Route::delete('/currencies/{id}', 'CurrencyController@delete');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/ratios', 'RatioController@get_ratios');
Route::post('/ratios/set', 'RatioController@set_ratios');





Route::get('/ratios', 'RatioController@index');

Route::get('/ratios/{id}', 'RatioController@show');

Route::post('/ratios', 'RatioController@store');



