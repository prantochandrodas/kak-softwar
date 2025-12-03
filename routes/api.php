<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


//settings
Route::prefix('settings')->group(function () {
    Route::get('general', [\App\Http\Controllers\Api\Website\SettingController::class, 'generalSetting']);
});

Route::prefix('home')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Website\HomeController::class, 'home']);
});
