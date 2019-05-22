<?php

Route::get('/', function () {
   return view('front');
});
Route::get('/admin', function () {
   return view('welcome');
});
