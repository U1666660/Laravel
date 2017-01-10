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

Route::get('/', function () {
    return view('pages/welcome'); //resources/views/pages/welcome.blade.php
  });

Route::get('/about', function () {
    return view('pages/about'); //resources/views/pages/about.blade.php
  });

Route::get('/contact', function () {
      return view('pages/contact'); //resources/views/pages/contact.blade.php
  });
