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

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');
Route::resource('youngs', 'User\YoungController');
Route::resource('professionals', 'User\ProfessionalController');
Route::resource('establishments', 'EstablishmentController');
Route::resource('map', 'MapPOIController');
Route::resource('articles', 'ArticleController');
Route::resource('advices', 'AdviceController');