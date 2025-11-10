<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});


Route::get('main', function(){
    return "This is The world of Programming";
});