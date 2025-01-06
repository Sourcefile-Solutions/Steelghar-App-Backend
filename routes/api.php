<?php

use App\Http\Controllers\MobileApp\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/app.php';


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

