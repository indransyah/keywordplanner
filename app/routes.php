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

// Route::pattern('id', '[0-9]+');
// Route::pattern('criterion_id', '[0-9]+');

Route::get('/', 'HomeController@getIndex');
Route::controller('home', 'HomeController');
Route::controller('keyword', 'KeywordsController');

Route::get('user/login', array('before' => 'guest', 'uses' => 'UsersController@getLogin'));
Route::controller('user', 'UsersController');
Route::controller('pairwisecomparison', 'PairwisecomparisonsController');

Route::group(array('before' => 'auth'), function()
{
    Route::resource('criteria', 'CriteriaController');
    Route::get('subcriteria/create/{criterion_id}', array('uses' => 'SubcriteriaController@create'));
    Route::post('subcriteria/create/{criterion_id}', array('uses' => 'SubcriteriaController@store'));
    Route::get('subcriteria/{id}/edit/{criterion_id}', array('uses' => 'SubcriteriaController@edit'));
    Route::put('subcriteria/{id}/edit/{criterion_id}', array('uses' => 'SubcriteriaController@update'));
    Route::delete('subcriteria/{id}/{criterion_id}', array('uses' => 'SubcriteriaController@destroy'));
	Route::resource('subcriteria', 'SubcriteriaController');
	Route::controller('judgment', 'JudgmentsController');
});