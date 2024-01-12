<?php

use Illuminate\Support\Facades\Route;

Route::get('/generate', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    \Illuminate\Support\Facades\Artisan::call('db:seed');
});

Route::get('/', function () {
    return view('welcome');
});
