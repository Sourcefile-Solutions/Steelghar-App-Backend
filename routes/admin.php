<?php


// use App\Http\Controllers\BannerController;
// use App\Http\Controllers\BrandController;
// use App\Http\Controllers\CartController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\CheckoutpaymentController;
// use App\Http\Controllers\DivisionController;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\InvoiceController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\FabircatorController;
// use App\Http\Controllers\NotificationController;
// use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\PermissionController;
// use App\Http\Controllers\PincodeController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\RegisteredFabricatorController;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\ScreenshotController;
// use App\Http\Controllers\SettingController;
// use App\Http\Controllers\SteeldetailController;
// use App\Http\Controllers\SubcategoryController;
// use App\Http\Controllers\SubdivisionController;
// use App\Http\Controllers\TestimonialController;
// use App\Http\Controllers\TmtdetailController;
// use App\Http\Controllers\AlertController;
// use App\Http\Controllers\ExpertAdviceController;
// use App\Http\Controllers\PricingcategoryController;
// use App\Http\Controllers\RoofingController;
// use App\Models\Pricingcategory;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPriceController;
use App\Http\Controllers\CheckoutpaymentController;
use App\Http\Controllers\Console\Product\MeshController;
use App\Http\Controllers\Console\Product\OtherProductController;
use App\Http\Controllers\Console\Product\RoofController;
use App\Http\Controllers\Console\Product\TmtController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpertAdviceController;
use App\Http\Controllers\FabircatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MinimumChargeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\RoofingColorController;
use App\Http\Controllers\RoofingThicknessController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TmtdetailController;

Route::domain('console.localhost')->group(function () {

    Route::middleware('guest')->group(function () {

        Route::post('admin', [AuthController::class, 'admin'])
            ->name('console.admin');

        Route::get('login', [AuthController::class, 'loginPage'])
            ->name('login');

        Route::post('login', [AuthController::class, 'login']);
        
       
        
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');
    });

    Route::middleware('auth')->group(function () {



        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('logout');


        Route::name('console.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('home');
            Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');

            Route::get('fabricators', [FabircatorController::class, 'index'])->name('fabricators.index');
            Route::get('fabricators/{fabricator}', [FabircatorController::class, 'show'])->name('fabricators.show');
            Route::put('fabricators/{fabricator}', [FabircatorController::class, 'update'])->name('fabricators.update');

            Route::get('push-notifications', [PushNotificationController::class, 'index'])->name('push-notifications.index');
            Route::post('push-notifications', [PushNotificationController::class, 'store'])->name('push-notifications.store');

            Route::get('expert-advices', [ExpertAdviceController::class, 'index'])->name('expert-advices.index');
            Route::delete('expert-advices/{expertAdvice}', [ExpertAdviceController::class, 'destroy'])->name('expert-advices.destroy');

            Route::resource('banners', BannerController::class);
            Route::resource('testimonials', TestimonialController::class);

            Route::resource('delivery-charges', MinimumChargeController::class);

            Route::resource('checkoutpayments', CheckoutpaymentController::class);

            Route::resource('pincodes', PincodeController::class);

            Route::resource('settings', SettingController::class);

            Route::resource('brands', BrandController::class);

            Route::resource('tmt-details', TmtdetailController::class);
            Route::GET('tmtweight/{id}', [TmtdetailController::class, 'weight']);

            Route::resource('roofing-colors', RoofingColorController::class);
            Route::resource('roofing-thickness', RoofingThicknessController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('category-prices', CategoryPriceController::class);
            Route::get('/get-category-price/{id}', [CategoryPriceController::class, 'getCategoryPrice']);
            Route::resource('sub-categories', SubcategoryController::class);
            Route::GET('get-subcategory-by-category/{category}', [SubcategoryController::class, 'getSubcategoriesByCategory']);
            Route::resource('products', ProductController::class);

            Route::POST('products-mesh-store', [MeshController::class, 'store'])->name('products.mesh.store');
            Route::POST('products-roof-store', [RoofController::class, 'store'])->name('products.roof.store');
            Route::POST('products-other-store', [OtherProductController::class, 'store'])->name('products.other.store');

            Route::GET('get-product-form', [ProductController::class, 'getProductForm']);
            Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::post('orders/{order}', [OrderController::class, 'updateStatus']);
            Route::post('order-accept/{order}', [OrderController::class, 'accept']);
            Route::post('order-reject/{order}', [OrderController::class, 'reject']);

            Route::post('order-payment', [PaymentController::class, 'store']);


            // Route::get('add-tmt-product', [ProductController::class, 'addtmt']);
            Route::get('add-mesh-product', [ProductController::class, 'addmesh']);
            Route::get('add-roof-product', [ProductController::class, 'addroof']);
            Route::get('add-other-product', [ProductController::class, 'addother']);
            Route::post('edit-tmt-product/{product}', [TmtController::class, 'update'])->name('edit-tmt-product');

            Route::post('edit-mesh-product/{product}', [MeshController::class, 'update'])->name('edit-mesh-product');
            Route::post('edit-roof-product/{product}', [RoofController::class, 'update'])->name('edit-roof-product');
            Route::post('edit-other-product/{product}', [OtherProductController::class, 'update'])->name('edit-other-product');
        });
    });





    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });



    // Route::GET('/download-invoice/{order}', [InvoiceController::class, 'invoiceDownload'])->middleware('auth')->name('invoice.download');



    // // registered Fabricators
    // Route::GET('registered-fabricator', [RegisteredFabricatorController::class, 'index'])->middleware('auth')->name('registered-fabricator.index');
    // Route::delete('registered-fabricator/{registeredFabricator}', [RegisteredFabricatorController::class, 'destroy'])->middleware('auth')->name('registered-fabricator.delete');

    // Route::resource('expertadvices', ExpertAdviceController::class);
    // Route::delete('experts/{id}', [ExpertAdviceController::class, 'destroy'])->middleware('auth')->name('expert.delete');



    // //Steel Details
    // Route::resource('steeldetails', SteeldetailController::class)->middleware('auth');

    // //TMT Details
    // 
    //

    // //TMT Details


    // //Categories
    // 

    // //Subcategories
    // 
    //

    // //Divisions
    // Route::resource('divisions', DivisionController::class)->middleware('auth');
    // Route::GET('get-divisions-by-subcategory/{subcategory}', [DivisionController::class, 'getDivisionsBySubcategory'])->middleware('auth');

    // //Subdivisions
    // Route::resource('subdivisions', SubdivisionController::class)->middleware('auth');
    // Route::GET('get-subdivisions-by-division/{division}', [SubdivisionController::class, 'getSubdivisionByDivision'])->middleware('auth');

    // //Subdivisions
    // 




    // //Roles
    // Route::resource('roles', RoleController::class)->middleware('auth');

    // //Permissions
    // Route::resource('permissions', PermissionController::class)->middleware('auth');



    // //Base Price
    // Route::put('prices/{ps}', [SettingController::class, 'updatePrice'])->name('price.update')->middleware('auth');

    // //Screenshots
    // Route::resource('screenshots', ScreenshotController::class)->middleware('auth');



    // //Checkout Payment
    // Route::resource('checkoutpayments', CheckoutpaymentController::class)->middleware('auth');





    // Route::group(['middleware' => ['auth']], function () {

    //     Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    //     Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    //     Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');


    //     Route::post('order-accept/{order}', [OrderController::class, 'accept']);
    //     Route::post('order-reject/{order}', [OrderController::class, 'reject']);
    //     Route::post('order-update-status/{order}', [OrderController::class, 'updateStatus'])->name('orders.status-update');

    //     Route::post('order-payment-add/{order}', [PaymentController::class, 'addPayment']);
    //     Route::get('carts', [CartController::class, 'index'])->name('carts.index');
    //     Route::get('carts/{id}', [CartController::class, 'show'])->name('carts.show');

    //     Route::get('fabricators', [FabircatorController::class, 'index'])->name('fabricators.index');
    //     Route::get('fabricators/{id}', [FabircatorController::class, 'show'])->name('fabricators.show');
    //     Route::put('fabricators/{fabricator}', [FabircatorController::class, 'update'])->name('fabricators.update');
    //     Route::delete('fabricators/{fabricator}', [FabircatorController::class, 'destroy'])->name('fabricators.delete');
    //     Route::get('get-alerts', [AlertController::class, 'getAlert'])->name('alerts.get');
    //     Route::get('alerts', [AlertController::class, 'index'])->name('alerts.index');





    // });
});
