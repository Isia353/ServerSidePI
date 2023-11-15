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

//sin auth
Route::group(['middleware' => ['cors', 'ForceJsonResponse']], function () {

    Route::post('/login', [\App\Http\Controllers\Auth\ApiAuthController::class ,'login'])->name('login.api');
    Route::post('/register',[\App\Http\Controllers\Auth\ApiAuthController::class,'register'])->name('register.api');

});

//DoerOrReader

//Doer
Route::middleware(['auth:api','DoerOrReader'])->group(function () {
    Route::apiResource('/user', \App\Http\Controllers\UserController::class);
    Route::apiResource('/animal', \App\Http\Controllers\AnimalController::class)->except(['show',"index"]);;
    Route::apiResource('/zone', \App\Http\Controllers\ZoneController::class)->except(['show',"index"]);;
    Route::apiResource('/task', \App\Http\Controllers\TaskController::class);
    Route::apiResource('/event', \App\Http\Controllers\EventController::class)->except(['show',"index"]);;

});


//Reader , no roles only view
Route::middleware('auth:api')->group(function () {

    Route::post('/logout',[\App\Http\Controllers\Auth\ApiAuthController::class,'logout'])->name('logout.api');
    Route::get('/animal', [\App\Http\Controllers\AnimalController::class ,'index'])->name('animal-index.api');
    Route::get('/animal/{animal}', [\App\Http\Controllers\AnimalController::class ,'show'])->name('animal-show.api');
    Route::get('/zone', [\App\Http\Controllers\ZoneController::class ,'index'])->name('zone-index.api');
    Route::get('/zone/{zone}', [\App\Http\Controllers\ZoneController::class ,'show'])->name('zone-show.api');
    Route::get('/event', [\App\Http\Controllers\EventController::class ,'index'])->name('event-index.api');
    Route::get('/event/{event}', [\App\Http\Controllers\EventController::class ,'show'])->name('event-show.api');


});



