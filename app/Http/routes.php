<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});

Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('welcome', 'IndexController@welcome');
    Route::post('user/index', 'AdminController@index');
    Route::resource('user','AdminController');
    Route::post('user/delall','AdminController@delall');
    Route::post('user/changeStatus','AdminController@changeStatus');
    Route::resource('role','RoleController');
    Route::resource('power','PowerController');
    Route::resource('rule','RuleController');
    Route::resource('category','CategoryController');
    Route::resource('substance','SubstanceController');
    Route::any('upload', 'BaseController@upload');
});
