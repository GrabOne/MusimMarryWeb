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
Route::controller('api/v1','ApiController');
Route::controller('test','TestController');
Route::get('/', function()
{
	return View::make('hello');
});

App::bind('UserRepo','DbUserRepo');
App::bind('PromocodeRepo','DbPromocodeRepo');
App::bind('PaymentRepo','DbPaymentRepo');
App::bind('OccupationRepo','DbOccupationRepo');