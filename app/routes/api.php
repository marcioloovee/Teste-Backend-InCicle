<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
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

Route::Apiresource('/countries', CountryController::class);

Route::get('/cities/exists', '\App\Http\Controllers\CityController@existsCity')->name('cities.exists');
Route::Apiresource('/cities', CityController::class);

Route::Apiresource('/users', UserController::class);

Route::Apiresource('/logs', LogController::class);
