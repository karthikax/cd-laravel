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

Route::get('/', function () { return 'welcome'; });

Route::get('/articles', 'ArticleController@listAll');
Route::get('/articles/{id}', 'ArticleController@view');
Route::get('/articles/{id}/author', 'ArticleController@viewAuthor');
Route::post('/articles/create', 'ArticleController@create');
Route::post('/articles/{id}', 'ArticleController@edit');
Route::delete('/articles/{id}', 'ArticleController@delete');

Route::get('/author/{uid}/articles', 'ArticleController@viewAuthorsArticles');