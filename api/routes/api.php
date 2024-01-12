<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('house', [\App\Http\Controllers\SiteController::class, 'house'])->name('house');
Route::get('type_room', [\App\Http\Controllers\SiteController::class, 'type_room'])->name('type_room');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
