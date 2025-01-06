<?php

use App\Http\Controllers\Console\Product\TmtController;
use Illuminate\Support\Facades\Route;

Route::get('add-tmt-product', [TmtController::class, 'create']);
Route::post('add-tmt-product', [TmtController::class, 'store'])->name('add-tmt-product');
