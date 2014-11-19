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
Route::get('/admin/tickets', 'HelpDeskController@adminTicketsAction');
Route::get('/admin/editTicket/{id}', 'HelpDeskController@adminEditTicketAction');

//session.auth being 0 means manually logged out
//" being 1 means logged in to regular site (url starting in "/secure/*")
//" being 2 means logged in to admin site (url starting in "/admin")
Route::filter('secure', function()
{
    if (!Session::has('auth') || Session::get('auth') == 0)
    {
        return Redirect::to('/login');
    }
});
Route::when('secure/*', 'secure');
Route::filter('admin', function()
{
    if (Session::get('auth') != 2)
    {
        if (!Session::has('auth') || Session::get('auth') == 0)
        {
            return Redirect::to('/login');
        }else{
            return Redirect::to('/login?admin');//must authenticate twice to log into admin panel
        }
    }
});
Route::when('admin/*', 'admin');

