<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
//customer
//register
Route::get('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])
    ->name('register');
Route::post('/register/send-otp', [\App\Http\Controllers\Auth\AuthController::class, 'sendOTP'])
    ->name('register.send-otp');
Route::post('/register/verify-otp', [\App\Http\Controllers\Auth\AuthController::class, 'verifyOTP'])
    ->name('register.verify-otp');
Route::get('/register/complete', [\App\Http\Controllers\Auth\AuthController::class, 'showCompleteForm'])
    ->name('register.complete');
Route::post('/register/store', [\App\Http\Controllers\Auth\AuthController::class, 'store'])
    ->name('register.store');
//login
Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'showCustomerLogin'])
    ->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'customerLogin'])
    ->name('customerLogin');
Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logoutCustomer'])
    ->name('logout');
//

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::get('/product/{id}', [\App\Http\Controllers\HomeController::class, 'productDetail'])
    ->name('product.detail');
//cart
// Cart routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])
    ->name('cart.index');
Route::post('/cart', [\App\Http\Controllers\CartController::class, 'addToCart'])
    ->name('cart.add');
Route::post('/cart/update-quantity', [\App\Http\Controllers\CartController::class, 'updateQuantity'])
    ->name('cart.update-quantity');
Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'removeItem'])
    ->name('cart.remove');
Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clearCart'])
    ->name('cart.clear');

// Coupon
Route::post('/cart/apply-coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])
    ->name('cart.apply-coupon');
Route::post('/cart/remove-coupon', [\App\Http\Controllers\CartController::class, 'removeCoupon'])
    ->name('cart.remove-coupon');
//checkout
Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])
    ->name('checkout');
Route::post('/checkout', [\App\Http\Controllers\CartController::class, 'store'])
    ->name('checkout.store');

Route::post('/apply-discount', [\App\Http\Controllers\CartController::class, 'applyDiscount'])->name('discount.apply');

//Order - History
Route::get('/order-history', [\App\Http\Controllers\OrderController::class, 'orderHistory'])
    ->name('orderHistory');
Route::get('/order-history/filter/{status_id}', [\App\Http\Controllers\OrderController::class, 'filter'])
    ->name('orders.filter');
Route::get('/order-detail/{order}', [\App\Http\Controllers\OrderController::class, 'show'])
    ->name('orderDetail');
Route::post('/order/{order}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])
    ->name('order.cancel');





//admin - login/logout
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/loginAdmin', [\App\Http\Controllers\UserController::class, 'login'])
        ->name('loginAdmin');
    Route::post('/loginAdmin', [\App\Http\Controllers\UserController::class, 'loginProcess'])
        ->name('loginProcess');
    Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])
        ->name('logoutAdmin');

    Route::middleware(['auth', 'admin'])->group(function (){
        //admin - dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');
        //account
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])
                ->name('users.index');
            Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])
                ->name('users.create');
            Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])
                ->name('users.store');
            Route::get('/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])
                ->name('users.edit');
            Route::put('/update/{user}', [\App\Http\Controllers\UserController::class, 'update'])
                ->name('users.update');
            Route::delete('/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])
                ->name('users.destroy');
        });
        //
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('brands', \App\Http\Controllers\BrandController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('materials', \App\Http\Controllers\MaterialController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('colors', \App\Http\Controllers\ColorController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('sizes', \App\Http\Controllers\SizeController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        // Promotions & Order Status
        Route::resource('promotions', \App\Http\Controllers\PromotionController::class)->except(['show']);
        Route::resource('order-status', \App\Http\Controllers\OrderStatusController::class)
            ->except(['show', 'edit', 'update', 'destroy']);
        // Roles & Permissions
        Route::prefix('roles')->group(function () {
            Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])
                ->name('roles.index');
            Route::get('/create', [\App\Http\Controllers\RoleController::class, 'create'])
                ->name('roles.create');
            Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])
                ->name('roles.store');
            Route::get('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'edit'])
                ->name('roles.edit');
            Route::put('/update/{role}', [\App\Http\Controllers\RoleController::class, 'update'])
                ->name('roles.update');
            Route::delete('/delete/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
                ->name('roles.destroy');

            // Permission Matrix
            Route::get('/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'editPermissions'])
                ->name('roles.permissions.edit');
            Route::post('/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'updatePermissions'])
                ->name('roles.permissions.update');
        });
            Route::resource('permissions', \App\Http\Controllers\PermissionController::class)
                ->except(['show', 'edit', 'update', 'destroy']);


            // Products
        Route::prefix('products')->group(function () {
            Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
            Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
            Route::get('/show/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
            Route::put('/update/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
            Route::delete('/variants/{productVariant}', [\App\Http\Controllers\ProductVariantController::class, 'destroy'])
                ->name('variants.destroy');
        });
        Route::prefix('orders')->group(function (){
            Route::get('/', [\App\Http\Controllers\OrderController::class, 'index'])
                ->name('orders.index');
            Route::get('/filter/{status_id}', [\App\Http\Controllers\OrderController::class, 'filterOrder'])
                ->name('orders.filterOrder');
            Route::get('/{id}/items', [\App\Http\Controllers\OrderItemController::class, 'showItems'])
                ->name('orders.items');
            Route::post('/{id}/update', [\App\Http\Controllers\OrderItemController::class, 'updateOrder'])
                ->name('orders.updateOrder');

            // Xóa order (nếu cần)
            Route::delete('/{id}', [\App\Models\OrderItem::class, 'destroy'])
                ->name('delete');
        });



    });
});



//CURD
//category
//Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])
//    ->name('categories.index');
//Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])
//    ->name('categories.create');
//Route::post('/categories/store', [\App\Http\Controllers\CategoryController::class, 'store'])
//    ->name('categories.store');
//Route::get('/categories/edit/{category}', [\App\Http\Controllers\CategoryController::class, 'edit'])
//    ->name('categories.edit');
//Route::put('/categories/edit/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])
//    ->name('categories.update');
//Route::delete('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])
//    ->name('categories.destroy');
//brand
//Route::get('/brands', [\App\Http\Controllers\BrandController::class, 'index'])
//    ->name('brands.index');
//Route::get('/brands/create', [\App\Http\Controllers\BrandController::class, 'create'])
//    ->name('brands.create');
//Route::post('/brands/store', [\App\Http\Controllers\BrandController::class, 'store'])
//    ->name('brands.store');
//Route::get('/brands/edit/{brand}', [\App\Http\Controllers\BrandController::class, 'edit'])
//    ->name('brands.edit');
//Route::put('/brands/edit/{brand}', [\App\Http\Controllers\BrandController::class, 'update'])
//    ->name('brands.update');
//Route::delete('/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'destroy'])
//    ->name('brands.destroy');
//material
//Route::prefix('/materials')->group(function () {
//    Route::get('/', [\App\Http\Controllers\MaterialController::class, 'index'])
//        ->name('materials.index');
//    Route::get('/create', [\App\Http\Controllers\MaterialController::class, 'create'])
//        ->name('materials.create');
//
//    Route::post('/store', [\App\Http\Controllers\MaterialController::class, 'store'])
//        ->name('materials.store');
//
//    Route::get('/edit/{material}', [\App\Http\Controllers\MaterialController::class, 'edit'])
//        ->name('materials.edit');
//    Route::put('/edit/{material}', [\App\Http\Controllers\MaterialController::class, 'update'])
//        ->name('materials.update');
//    Route::delete('/{material}', [\App\Http\Controllers\MaterialController::class, 'destroy'])
//        ->name('materials.destroy');
//});
//color
//Route::prefix('/colors')->group(function () {
//    Route::get('/', [\App\Http\Controllers\ColorController::class, 'index'])
//        ->name('colors.index');
//    Route::get('/create', [\App\Http\Controllers\ColorController::class, 'create'])
//        ->name('colors.create');
//    Route::post('/store', [\App\Http\Controllers\ColorController::class, 'store'])
//        ->name('colors.store');
//    Route::get('/edit/{color}', [\App\Http\Controllers\ColorController::class, 'edit'])
//        ->name('colors.edit');
//    Route::put('/edit/{color}', [\App\Http\Controllers\ColorController::class, 'update'])
//        ->name('colors.update');
//    Route::delete('/{color}', [\App\Http\Controllers\ColorController::class, 'destroy'])
//        ->name('colors.destroy');
//});
//size
//Route::prefix('/sizes')->group(function () {
//    Route::get('/', [\App\Http\Controllers\SizeController::class, 'index'])
//        ->name('sizes.index');
//    Route::get('/create', [\App\Http\Controllers\SizeController::class, 'create'])
//        ->name('sizes.create');
//    Route::post('/store', [\App\Http\Controllers\SizeController::class, 'store'])
//        ->name('sizes.store');
//    Route::get('/edit/{size}', [\App\Http\Controllers\SizeController::class, 'edit'])
//        ->name('sizes.edit');
//    Route::put('/edit/{size}', [\App\Http\Controllers\SizeController::class, 'update'])
//        ->name('sizes.update');
//    Route::delete('/{size}', [\App\Http\Controllers\SizeController::class, 'destroy'])
//        ->name('sizes.destroy');
//});
//order_status
//Route::prefix('/order-status')->group(function () {
//    Route::get('/', [\App\Http\Controllers\OrderStatusController::class, 'index'])
//        ->name('order-status.index');
//    Route::get('/create', [\App\Http\Controllers\OrderStatusController::class, 'create'])
//        ->name('order-status.create');
//    Route::post('/store', [\App\Http\Controllers\OrderStatusController::class, 'store'])
//        ->name('order-status.store');
//});
////promotion
//Route::prefix('/promotions')->group(function () {
//    Route::get('/', [\App\Http\Controllers\PromotionController::class, 'index'])
//        ->name('promotions.index');
//    Route::get('/create', [\App\Http\Controllers\PromotionController::class, 'create'])
//        ->name('promotions.create');
//    Route::post('/store', [\App\Http\Controllers\PromotionController::class, 'store'])
//        ->name('promotions.store');
//    Route::get('/edit/{promotion}', [\App\Http\Controllers\PromotionController::class, 'edit'])
//        ->name('promotions.edit');
//    Route::put('/edit/{promotion}', [\App\Http\Controllers\PromotionController::class, 'update'])
//        ->name('promotions.update');
//    Route::delete('/{promotion}', [\App\Http\Controllers\PromotionController::class, 'destroy'])
//        ->name('promotions.destroy');
//});
//role
//Route::prefix('/roles')->group(function () {
//    Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])
//        ->name('roles.index');
//    Route::get('/create', [\App\Http\Controllers\RoleController::class, 'create'])
//        ->name('roles.create');
//    Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])
//        ->name('roles.store');
//    Route::get('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'edit'])
//        ->name('roles.edit');
//    Route::put('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'update'])
//        ->name('roles.update');
//    Route::delete('/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
//        ->name('roles.destroy');
//});
//role
//Route::prefix('/roles')->group(function () {
//    Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])
//        ->name('roles.index');
//    Route::get('/create', [\App\Http\Controllers\RoleController::class, 'create'])
//        ->name('roles.create');
//    Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])
//        ->name('roles.store');
//    Route::get('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'edit'])
//        ->name('roles.edit');
//    Route::put('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'update'])
//        ->name('roles.update');
//    Route::delete('/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
//        ->name('roles.destroy');
//    // show matrix
//    Route::get('/roles/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'editPermissions'])
//        ->name('roles.permissions.edit');
//    // update matrix
//    Route::post('/roles/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'updatePermissions'])
//        ->name('roles.permissions.update');
//});
//permission
//Route::prefix('/permissions')->group(function () {
//    Route::get('/', [\App\Http\Controllers\PermissionController::class, 'index'])
//        ->name('permissions.index');
//    Route::get('/create', [\App\Http\Controllers\PermissionController::class, 'create'])
//        ->name('permissions.create');
//    Route::post('/store', [\App\Http\Controllers\PermissionController::class, 'store'])
//        ->name('permissions.store');
//    Route::get('/edit/{permission}', [\App\Http\Controllers\PermissionController::class, 'edit'])
//        ->name('permissions.edit');
//    Route::put('/edit/{permission}', [\App\Http\Controllers\PermissionController::class, 'update'])
//        ->name('permissions.update');
//    Route::delete('/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])
//        ->name('permissions.destroy');
//});

//});
//product
//Route::prefix('/products')->group(function () {
//    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])
//        ->name('products.index');
//    Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])
//        ->name('products.create');
//    Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])
//        ->name('products.store');
//    Route::put('/show/{product}', [\App\Http\Controllers\ProductController::class, 'update'])
//        ->name('products.update');
//    Route::get('/show/{product}', [\App\Http\Controllers\ProductController::class, 'show'])
//        ->name('products.show');
//    Route::delete('/variants/{productVariant}',
//        [\App\Http\Controllers\ProductVariantController::class, 'destroy']
//    )->name('variants.destroy');
//});






