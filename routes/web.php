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

Route::get('/', function () {
    return view('home');
})->middleware('guest')
    ->name('home');

Route::resource('cabinets', 'CabinetController')->only(['index', 'show']);
Route::resource('campaigns', 'CampaignController');
Route::resource('ads', 'AdController')->only(['edit', 'update', 'destroy']);


Route::get('login', 'SessionController@redirect')
    ->middleware('guest')
    ->name('login');

Route::get('login/success', 'SessionController@login')
    ->middleware('guest')
    ->name('login.success');

Route::post('logout', 'SessionController@logout')
    ->middleware('auth')
    ->name('logout');