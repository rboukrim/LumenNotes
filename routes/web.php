<?php

/*
 |--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
	return $app->version();
});

	$app->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function($app)
	{
		$app->get('notes','NoteController@index');

		$app->get('notes/{id}','NoteController@getNote');

		$app->post('notes','NoteController@createNote');

		$app->put('notes/{id}','NoteController@updateNote');

		$app->delete('notes/{id}','NoteController@deleteNote');
	});
