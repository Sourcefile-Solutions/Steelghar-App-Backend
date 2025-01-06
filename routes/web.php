<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\Public\AddressController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\ExpertAdviceController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\OrderController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\WishlistController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin.php';

require __DIR__ . '/new.php';
require __DIR__ . '/app.php';





Route::name('public.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [PageController::class, 'about'])->name('about');
    Route::get('expert-advice', [PageController::class, 'expertAdvice'])->name('expert-advice');
    Route::post('expert-advice', [PageController::class, 'expertAdviceStore'])->name('expert-advice-store');
    Route::get('calculator', [PageController::class, 'calculator'])->name('calculator');
    Route::get('contact', [PageController::class, 'contact'])->name('contact');
    Route::get('brands', [PageController::class, 'brands'])->name('brands');
    Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])->name('terms-and-conditions');
    Route::get('return-policy', [PageController::class, 'returnPolicy'])->name('return-policy');
    Route::get('privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');

    Route::post('razorpay-callback', [PaymentController::class, 'callBack'])->name('razorpay-callback');



    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
        Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
        Route::POST('/login', [AuthController::class, 'login'])->name('web-login');
        Route::POST('/register', [AuthController::class, 'register'])->name('web-register');
        Route::POST('/otp-verify', [AuthController::class, 'OtpVerify'])->name('otp-verify');
    });
 
    Route::middleware('auth:customer')->group(function () {

        Route::get('products/{category?}/{subcategory?}', [ProductController::class, 'index'])->name('products.index');
        Route::GET('search', [ProductController::class, 'search']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('public.add-to-cart');
        Route::post('/update-to-cart/{product}', [CartController::class, 'updateToCart']);


        Route::post('remove-from-cart', [CartController::class, 'removeFromCart']);
        Route::get('carts', [CartController::class, 'index'])->name('cart.index');

        Route::get('get-cart-update-view', [CartController::class, 'edit'])->name('cart.edit');
        Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

        Route::get('checkout/payments', [PaymentController::class, 'index']);

        Route::post('checkout/payments', [CheckoutController::class, 'payment'])->name('checkout.payment.index');
        Route::post('checkout', [CheckoutController::class, 'paymentSuccess'])->name('checkout.payment.success');

        Route::get('checkout/success/{order_id}', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.order.success');
        Route::resource('addressess', AddressController::class);

        Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::post('add-to-wishlist', [WishlistController::class, 'addToWishlist']);
        Route::get('add-to-card-from-wishlist/{id}', [WishlistController::class, 'addToCart']);





        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('profile/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('profile/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

        Route::get('profile/addressess', [ProfileController::class, 'address'])->name('profile.address');
        Route::get('profile/addressess/create', [ProfileController::class, 'addressCreate'])->name('profile.address.create');
        Route::post('profile/addressess', [ProfileController::class, 'addressStore'])->name('profile.address.store');
        Route::get('profile/addressess/{address}/edit', [ProfileController::class, 'addressEdit'])->name('profile.address.edit');
        Route::put('profile/addressess/{address}', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');
        Route::delete('profile/addressess/{address}', [ProfileController::class, 'addressDelete'])->name('profile.address.delete');
    });
});





// Route::domain('console.localhost')->group(function () {
//     Route::get('/banners', function () {
//         return 150;
//     });
//     // Route::get('banners', [BannerController::class, 'index'])->name('banners.index');
//     // Route::resource('banners', BannerController::class);
// });
