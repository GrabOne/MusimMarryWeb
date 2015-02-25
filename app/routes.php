<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
App::bind('UserRepository','DbUserRepository');


Route::filter('admin_login',function(){
	if(!Auth::check())
		return Redirect::to('admin/login');
});
Route::when('admin/neues-angebote','admin_login');
Route::when('admin/angebote','admin_login');

Route::controller('ajax','AjaxController');
Route::get('/',function(){
	return Redirect::to('admin');
});
