<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('client', 'App\Http\Controllers\ClientController');
Route::apiResource('car', 'App\Http\Controllers\CarController');
Route::apiResource('rental', 'App\Http\Controllers\RentalController');
Route::apiResource('brand', 'App\Http\Controllers\BrandController');
Route::apiResource('carmodel', 'App\Http\Controllers\CarModelController');
