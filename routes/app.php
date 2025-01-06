<?php

use App\Http\Controllers\MobileApp\AuthController;
use App\Http\Controllers\MobileApp\HomeController;
use App\Http\Controllers\MobileApp\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileApp\AddressController;
use App\Http\Controllers\MobileApp\CartController;
use App\Http\Controllers\MobileApp\FabricatorController;
use App\Http\Controllers\MobileApp\PageController;
use App\Http\Controllers\MobileApp\ProfileController;
use App\Http\Controllers\MobileApp\WishlistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/home-data', [HomeController::class, 'index']);
    Route::get('/categories', [ProductController::class, 'category']);
    Route::get('/sub-categories/{category_id}', [ProductController::class, 'subcategory']);
    Route::get('/products/{sub_category_id}', [ProductController::class, 'product']);
    Route::get('/get-product-data', [ProductController::class, 'productData']);
    

    Route::put('profile', [ProfileController::class, 'update']);
    Route::post('fabricators', [FabricatorController::class, 'store']);
    Route::get('fabricators', [FabricatorController::class, 'index']);



    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('addresses', [AddressController::class, 'store']);
    Route::delete('addresses/{id}', [AddressController::class, 'destroy']);
    Route::post('updateDefault', [AddressController::class, 'updateDefaultAddress']);


    Route::get('wishlists', [WishlistController::class, 'index']);
    // Route::post('wishlists', [WishlistController::class, 'addToWishlist']);
    Route::post('add-to-wishlist', [WishlistController::class, 'addToWishlist']);


    Route::get('carts', [CartController::class, 'index']);
    
    
    Route::get('checkout', [CartController::class, 'checkoutDetails']);
        Route::post('updateCart', [CartController::class, 'updateToCart']);

        Route::post('expert-advice', [PageController::class, 'expertAdviceStore'])->name('expert-advice-store');

        
        Route::get('get-cart-update-view', [CartController::class, 'edit']);
        
    Route::delete('deleteitem/{id}', [CartController::class, 'destroy']);


    

    Route::post('carts', [CartController::class, 'addToCart']);
});
