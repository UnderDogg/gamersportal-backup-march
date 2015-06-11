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

Route::get('/', 'StoreController@index');

Route::get('/test', function(){
	
	$categories = App\Models\Category::all();
	

$tree = App\Models\Category::all()->toHierarchy();

	return $tree;
});

Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', 'AdminController@index');

	/**
	 * Category related routes
	 */
	Route::get('/categories', [
		'as' => 'AdminCategoryIndex',
		'uses' => 'AdminCategoryController@index'
	]);

	Route::get('/categories/create', [
		'as' => 'AdminCategoryCreate',
		'uses' => 'AdminCategoryController@create'
	]);

	Route::post('/categories', [
		'as' => 'AdminCategoryStore',
		'uses' => 'AdminCategoryController@store'
	]);

	Route::get('/categories/{category}', [
		'as' => 'AdminCategoryShow',
		'uses' => 'AdminCategoryController@show'
	]);

	Route::get('/categories/{category}/edit', [
		'as' => 'AdminCategoryEdit',
		'uses' => 'AdminCategoryController@edit'
	]);

	Route::patch('/categories/{category}', [
		'as' => 'AdminCategoryUpdate',
		'uses' => 'AdminCategoryController@update'
	]);

	Route::get('/categories/{category}/delete', [
		'as' => 'AdminCategoryDelete',
		'uses' => 'AdminCategoryController@delete'
	]);

	Route::delete('/categories/{category}', [
		'as' => 'AdminCategoryDestroy',
		'uses' => 'AdminCategoryController@destroy'
	]);

	/**
	 * Product related routes
	 */
	Route::get('/products', [
		'as' => 'AdminProductIndex',
		'uses' => 'AdminProductController@index'
	]);

	Route::get('/products/create', [
		'as' => 'AdminProductCreate',
		'uses' => 'AdminProductController@create'
	]);

	Route::post('/products', [
		'as' => 'AdminProductStore',
		'uses' => 'AdminProductController@store'
	]);

	Route::get('/products/{product}', [
		'as' => 'AdminProductShow',
		'uses' => 'AdminProductController@show'
	]);

	Route::get('/products/{product}/edit', [
		'as' => 'AdminProductEdit',
		'uses' => 'AdminProductController@edit'
	]);

	Route::patch('/products/{product}', [
		'as' => 'AdminProductUpdate',
		'uses' => 'AdminProductController@update'
	]);

	Route::get('/products/{product}/delete', [
		'as' => 'AdminProductDelete',
		'uses' => 'AdminProductController@delete'
	]);

	Route::delete('/products/{product}', [
		'as' => 'AdminProductDestroy',
		'uses' => 'AdminProductController@destroy'
	]);
});

