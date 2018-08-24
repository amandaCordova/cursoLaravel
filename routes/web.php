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

Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);
//
Route::group(["middleware" => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'prefix' => LaravelLocalization::setLocale()], function () {
  
    Route::get('/home', 'HomeController@index')->name('home');
    Auth::routes();
    Route::get('/', function () {
        return view('welcome');
    });
    Route::group(["middleware" => "auth"], function () {
        Route::resource("peliculas", "PeliculaController");
        Route::resource("generos", "GeneroController")->except(['create', 'edit']);
        Route::post("generos/{id}/restore", "GeneroController@restore")->name("generos.restore");
        Route::post("generos/{id}/trash", "GeneroController@trash")->name("generos.trash");
    });
});
