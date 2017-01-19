<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(['middleware' => ['web']], function () {

    // domain.com/blog/slug-goes-here
  Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])
      ->where('slug', '[\w\d\-\_]+');

  Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);
  Route::get('contact', 'PagesController@getContact');
  Route::get('about', 'PagesController@getAbout');
  Route::get('/', 'PagesController@getIndex');
  Route::resource('posts','PostController');
});

  // Authentication Routes
  Auth::routes();

  Route::get('/home', 'HomeController@index');

  Route::get('profile', function () {
    // Only authenticated users may enter...
  })->middleware('auth');

  // Categories
  Route::resoure('categories', 'CategoryController');
