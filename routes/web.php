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


Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Country Routes
     */
     
    Route::get('/admin/country-list', 'CountryController@index')->name('home.index'); 
    Route::post('/admin/country-add', 'CountryController@create');
    Route::get('/admin/country-remove/{id}', 'CountryController@delete');

    Route::get('/admin/file-list', 'FileController@index');
    Route::post('/admin/file-add', 'FileController@create');
    Route::get('/admin/file-remove/{id}', 'FileController@delete');

    Route::get('/admin/type-list', 'VisaTypeController@index');
    Route::post('/admin/type-add', 'VisaTypeController@create');
    Route::get('/admin/type-remove/{id}', 'VisaTypeController@delete');

    Route::get('/admin/faq-list', 'VisaTypeDetailController@index');
    Route::post('/admin/faq-add', 'VisaTypeDetailController@create');
    Route::get('/admin/faq/{id}', 'VisaTypeDetailController@fetchById');
    Route::post('/admin/faq/{id}', 'VisaTypeDetailController@update');
    Route::get('/admin/faq-remove/{id}', 'VisaTypeDetailController@delete');

    Route::get('/admin/archive/{id}/{category}', 'ArchiveController@list');

    Route::get('/', 'HomeController@index')->name('home.index');

    Route::get('/admin/home', 'VisaTypeDetailController@all');
    Route::get('/admin/country/{id}', 'VisaTypeDetailController@selectedCountry');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});