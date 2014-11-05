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

Route::get('/', function()
{
	return View::make('hello');
});
Route::get('/', 'HelpDeskController@indexAction');
Route::get('/login', 'HelpDeskController@loginAction');
Route::post('/logincheck', 'HelpDeskController@loginCheckAction');
Route::get('/secure/browse', 'HelpDeskController@browseAction');
Route::get('/logout', 'HelpDeskController@logoutAction');
Route::get('/blog/add', 'BlogController@addAction');
Route::get('/blog/delete/{id}', 'BlogController@deleteAction');
Route::get('/blog/display', 'BlogController@displayAction');
Route::get('/blog/edit/{id}', 'BlogController@editAction');
Route::post('/blog/save', 'BlogController@saveAction');
Route::post('/blog/save/{id}', 'BlogController@saveAction');
// Set default route to match all other cases 
Route::any('{all}', 'BlogController@indexAction')->where('all', '.*');

