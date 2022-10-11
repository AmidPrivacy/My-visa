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
     **/
     
    Route::get('/admin/country-list', 'CountryController@index')->name('home.index'); 
    Route::get('/admin/country-search', 'CountryController@search'); 
    Route::post('/admin/country-add', 'CountryController@create');
    Route::get('/admin/country-remove/{id}', 'CountryController@delete');
    Route::get('/admin/country/{id}', 'CountryController@fetchById');
    Route::post('/admin/country/{id}', 'CountryController@update');
    Route::post('/admin/country-image/{id}', 'CountryController@updateImg');

    Route::get('/admin/file-list', 'FileController@index');
    Route::post('/admin/file-add', 'FileController@create');
    Route::get('/admin/file-search/{name}', 'FileController@search'); 
    Route::get('/admin/file-remove/{id}', 'FileController@delete');

    Route::get('/admin/excell-list', 'FileController@excellList');
    Route::post('/admin/excell-add', 'FileController@excellCreate');
    Route::get('/admin/excell-remove/{id}', 'FileController@excellDelete');

    Route::get('/admin/type-list', 'VisaTypeController@index');
    Route::post('/admin/type-add', 'VisaTypeController@create');
    Route::get('/admin/type/{id}', 'VisaTypeController@fetchById');
    Route::post('/admin/type/{id}', 'VisaTypeController@update');
    Route::get('/admin/type-search/{name}', 'VisaTypeController@search'); 
    Route::get('/admin/type-remove/{id}', 'VisaTypeController@delete');

    Route::get('/admin/faq-list', 'VisaTypeDetailController@index');
    Route::post('/admin/faq-add', 'VisaTypeDetailController@create');
    Route::get('/admin/faq/{id}', 'VisaTypeDetailController@fetchById');
    Route::post('/admin/faq/{id}', 'VisaTypeDetailController@update');
    Route::get('/admin/faq-remove/{id}', 'VisaTypeDetailController@delete');
    Route::get('/admin/faq-search', 'VisaTypeDetailController@search'); 

    Route::get('/admin/archive/{id}/{category}', 'ArchiveController@list');

    Route::get('/', 'HomeController@index');
    Route::get('/tours', 'HomeController@tours');
    Route::get('/visa-services', 'HomeController@visaServices');
    Route::get('/visa-appeal/{id}', 'HomeController@visaAppeal');
    Route::get('/faq', 'HomeController@faq');
    Route::get('/blog', 'HomeController@blog');

    // Route::get('/appeal', 'HomeController@index')->name('home.index');
    Route::get('/appeal', 'HomeController@appeal')->name('home.index');
    Route::get('/admin/crm', 'HomeController@crm');
    Route::get('/admin/get-call/{id}', 'HomeController@getCall');
    Route::get('/admin/get-calls', 'HomeController@getCalls');
    Route::get('/crm/create-call', 'HomeController@createCall');
    Route::post('/crm/update-call', 'HomeController@updateCall');



    Route::get('/home', 'VisaTypeDetailController@all');
    Route::get('/country/{id}', 'VisaTypeDetailController@selectedCountry');
    Route::get('/service-appeal/{id}', 'HomeController@serviceAppeal');

    Route::get('/search-country', 'HomeController@searchCountry');
 

    //Appeals...
    Route::get('/admin/appeals', 'AppealController@index');
    Route::post('/appeal', 'AppealController@create');
    Route::post('/admin/edit-status', 'AppealController@editStatus');
    Route::post('/admin/appeal-note-add', 'AppealController@addNote');
    Route::post('/admin/appoint-user', 'AppealController@appointUser');
    Route::get('/admin/appeal-search', 'AppealController@search');
    Route::get('/admin/appeal-note-list/{id}', 'AppealController@fetchNotes');

    //country and service appeals
    Route::get('/admin/country-appeals', 'CountryAppealController@index');
    Route::get('/admin/service-appeals', 'ServiceAppealController@index');

    Route::post('/country-appeal', 'HomeController@newCountryAppeal');
    Route::post('/service-appeal', 'HomeController@newServiceAppeal');



    //User status
    Route::put('/set-status', 'HomeController@setStatus');
    Route::get('/admin/users', 'HomeController@users');
    Route::post('/admin/admin-role-edit', 'HomeController@editAdminRole');
    Route::post('/admin/appeal-role-edit', 'HomeController@editAppealRole');
    Route::get('/admin/appeal-role-delete/{id}', 'HomeController@deleteAppealRole'); 

    Route::get('/admin/delete-user/{id}', 'HomeController@deleteUser');


    //Tours
    Route::get('/admin/tour-list', 'TourController@index');
    Route::post('/admin/tour-add', 'TourController@create');
    Route::get('/admin/tour/{id}', 'TourController@fetchById');
    Route::post('/admin/tour/{id}', 'TourController@update');
    Route::get('/admin/tour-search/{name}', 'TourController@search'); 
    Route::get('/admin/tour-remove/{id}', 'TourController@delete');
    Route::post('/admin/tour-image/{id}', 'TourController@updateImg');

    //Blogs
    Route::get('/admin/blog-list', 'BlogController@index');
    Route::post('/admin/blog-add', 'BlogController@create');
    Route::get('/admin/blog/{id}', 'BlogController@fetchById');
    Route::post('/admin/blog/{id}', 'BlogController@update');
    Route::get('/admin/blog-search/{name}', 'BlogController@search'); 
    Route::get('/admin/blog-remove/{id}', 'BlogController@delete');
    Route::post('/admin/blog-image/{id}', 'BlogController@updateImg');

    //Questions
    Route::get('/admin/question-list', 'QuestionnaireController@index');
    Route::post('/admin/question-add', 'QuestionnaireController@create');
    Route::get('/admin/question/{id}', 'QuestionnaireController@fetchById');
    Route::post('/admin/question/{id}', 'QuestionnaireController@update');
    Route::get('/admin/question-search/{name}', 'QuestionnaireController@search'); 
    Route::get('/admin/question-remove/{id}', 'QuestionnaireController@delete');

    Route::get('/admin/service-list', 'ServiceController@index'); 
    Route::get('/admin/service-search', 'ServiceController@search'); 
    Route::post('/admin/service-add', 'ServiceController@create');
    Route::get('/admin/service/{id}', 'ServiceController@fetchById');
    Route::post('/admin/service/{id}', 'ServiceController@update');
    Route::get('/admin/service-remove/{id}', 'ServiceController@delete');
    Route::post('/admin/service-image/{id}', 'ServiceController@updateImg');

    Route::get('/admin/contact', 'HomeController@contact'); 

    Route::get('/admin/contact/{id}/{status}', 'HomeController@setContactStatus'); 

    Route::get('/admin/type/{id}/{status}', 'VisaTypeController@setShowStatus'); 
 

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