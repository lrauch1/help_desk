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
Route::get('/secure/details/{id}', 'HelpDeskController@detailsAction');
Route::post('/secure/details/{id}', 'HelpDeskController@newMsgAction');
Route::get('/secure/new', 'HelpDeskController@newTicketAction');
Route::post('/secure/new', 'HelpDeskController@processNewTicketAction');
Route::get('/secure/settings', 'HelpDeskController@settingsAction');
Route::post('/secure/update/{table}/{id}', 'HelpDeskController@updateAction');
Route::get('/register', 'HelpDeskController@registerAction');
Route::post('/register', 'HelpDeskController@addUserAction');
// Set default route to match all other cases 
Route::any('{all}', 'BlogController@indexAction')->where('all', '.*');

