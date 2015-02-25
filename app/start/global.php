<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/
/**
 * Global Constant
 */
define('DEALS_PER_PAGE', 2);
define('NUMBER_RATE_START', 7);
define('STR_STATUS_ERROR', 'error');
define('STR_STATUS_SUCCESS', 'success');
define('TIME_ZONE', '+7');
define('GOOGLE_MAP_KEY', 'AIzaSyB_o5K_LHJGWwrNpZLun3-jl_psArEstzc');
define('STR_DIR_UPLOAD_DEAL_IMAGE','upload/deal/image/');
define('STR_DIR_UPLOAD_DEAL_IMAGE_THUMB','upload/deal/thumb/');
define('NEW_DEAL', 'new');
define('VIEW_TO_DATABASE', 1);
define('DATABASE_TO_VIEW', 2);


define('STR_ERROR_USER_VALIDATE','Validation error'); // error_code           = 1
define('STR_ERROR_VALIDATE','Validation error'); // error_code           = 1
define('STR_ERROR_LOGIN_FAIL', 'Login fail'); // error_code                   = 2
define('STR_ERROR_USER_EMAIL_EXIST', 'Email already exist'); // error_code    = 3
define('STR_ERROR_USER_EXIST', 'Username already exist'); // error_cde        = 4
define('STR_ERROR_EMAIL_NOT_FOUND', 'Email not foud'); // error_code          = 5
define('STR_ERROR_DEAL_NOT_FOUND', 'Deal not foud'); // error_code            = 6
define('STR_ERROR_NUMBER_STAR', 'Number start invalid'); // error_code        = 7
define('STR_ERROR_USER_NOT_FOUND', 'User not found'); // error_code           = 8
define('STR_ERROR_REMEMBER_TOKEN', 'Remember token not match'); // error_code = 9
define('STR_ERROR_RATED', 'this deal has been rated before'); // error_code   = 10
define('STR_ERROR_PASSWORD_NOT_MATCH', 'Password does not match'); // error_code   = 11
define('STR_ERROR_DEAL_ALREADY_SAVE', 'Deal already saved');// error_code   = 12
define('STR_ERROR_DEAL_NOT_SAVED', 'Deal not saved');// error_code   = 13
define('STR_ERROR_TIME', 'Time error');// error_code   = 14
define('STR_ERROR_QUANTITY', 'Quantity error');// error_code   = 15
define('STR_ERROR_BALANCE', 'Balance error');// error_code   = 16
define('STR_ERROR_USER_LOCATION_EXISTS', 'Location already exist');
define('STR_ERROR_FORGOT_TOKEN_NOT_MATCH', 'Forgot token not match or expiration');
define('STR_ERROR_FILE_TYPE', 'File type error');



ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
