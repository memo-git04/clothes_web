<?php

use Illuminate\Support\Facades\Route;

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

// Shop + tìm kiếm (public)
Route::get('/shop', [\App\Http\Controllers\ProductController::class, 'shop'])
    ->name('shop');
Route::get('/shop_men', [\App\Http\Controllers\ProductController::class, 'shopMen'])
    ->name('shop.men');
Route::get('/shop_women', [\App\Http\Controllers\ProductController::class, 'shopWomen'])
    ->name('shop.women');
Route::get('/search', [\App\Http\Controllers\ProductController::class, 'search'])
    ->name('search');

//blog
Route::get('/blog', [\App\Http\Controllers\HomeController::class, 'blog'])
    ->name('blog');

// Contact us (public)
Route::get('/contactus', [\App\Http\Controllers\ContactController::class, 'create'])
    ->name('contact');
Route::post('/contactus', [\App\Http\Controllers\ContactController::class, 'store'])
    ->name('contact.store');

// VNPay return
Route::get('/payment-return', [\App\Http\Controllers\CartController::class, 'paymentReturn'])
    ->name('payment.return');

// ============ Khu vực yêu cầu đăng nhập (khách hàng) ============
Route::middleware('auth')->group(function () {
    //cart
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

    // Coupon + Checkout
    Route::post('/checkout/apply-coupon', [\App\Http\Controllers\CartController::class, 'applyCoupon'])
        ->name('checkout.apply-coupon');
    Route::get('/checkout/remove-coupon', [\App\Http\Controllers\CartController::class, 'removeCoupon'])
        ->name('checkout.remove-coupon');
    Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])
        ->name('checkout');
    Route::post('/checkout', [\App\Http\Controllers\CartController::class, 'store'])
        ->name('checkout.store');
    Route::post('/buy-now', [\App\Http\Controllers\CartController::class, 'buyNow'])
        ->name('buy.now');

    // Thông tin tài khoản
    Route::get('/my-account', [\App\Http\Controllers\UserController::class, 'show'])
        ->name('profile');
    Route::put('/my-account', [\App\Http\Controllers\UserController::class, 'updateProfile'])
        ->name('profile.update');

    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])
        ->name('wishlist');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

    // Đánh giá sản phẩm
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
        ->name('reviews.store');

    // Lịch sử đơn hàng
    Route::get('/order-history', [\App\Http\Controllers\OrderController::class, 'orderHistory'])
        ->name('orderHistory');
    Route::get('/order-history/filter/{status_id}', [\App\Http\Controllers\OrderController::class, 'filter'])
        ->name('orders.filter');
    Route::get('/order-detail/{order}', [\App\Http\Controllers\OrderController::class, 'show'])
        ->name('orderDetail');
    Route::post('/order/{order}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])
        ->name('order.cancel');
});

//admin - login/logout (k cần auth)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/loginAdmin', [\App\Http\Controllers\UserController::class, 'login'])
        ->name('loginAdmin');
    Route::post('/loginAdmin', [\App\Http\Controllers\UserController::class, 'loginProcess'])
        ->name('loginProcess');
    Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])
        ->name('logoutAdmin');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin|manager'])->group(function () {
        //AI CŨNG CÓ QUYỀN XEM DASHBOARD
        //dashboard / báo cáo thống kê
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');
        // AJAX cho biểu đồ (bấm biểu đồ -> load danh sách)
        Route::get('/reports/revenue', [\App\Http\Controllers\Admin\DashboardController::class, 'revenue'])
            ->name('reports.revenue');
        Route::get('/reports/orders', [\App\Http\Controllers\Admin\DashboardController::class, 'ordersList'])
            ->name('reports.orders');
        Route::get('/reports/top-products', [\App\Http\Controllers\Admin\DashboardController::class, 'topProductsList'])
            ->name('reports.topProducts');

    //account
    Route::prefix('users')->group(function () {
        //admin - manager đều có quyền user.create nên vào được trang danh sách
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])
            ->middleware('permission:user.view')
            ->name('users.index');

        //chỉ AI CÓ QUYỀN USER.CREATE MỚI TRUY CẬP ĐƯỢC
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])
            ->middleware('permission:user.create')
            ->name('users.create');
        Route::post('/store', [\App\Http\Controllers\UserController::class, 'createAccountByAdmin'])
            ->middleware('permission:user.create')
            ->name('users.store');

        Route::get('/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])
            ->middleware('permission:user.edit')
            ->name('users.edit');
        Route::put('/update/{user}', [\App\Http\Controllers\UserController::class, 'update'])
            ->middleware('permission:user.edit')
            ->name('users.update');
        Route::delete('/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])
            ->middleware('permission:user.delete')
            ->name('users.destroy');
        //
        Route::get('/permissions/{user}', [\App\Http\Controllers\UserController::class, 'addPermissions'])
            ->middleware('permission:user.edit')
            ->name('users.permissions');
        Route::post('/permissions/{user}', [\App\Http\Controllers\UserController::class, 'addPermissionsPost'])
            ->middleware('permission:user.edit')
            ->name('users.permissions.post');

        Route::get('/show/permissions/{user}', [\App\Http\Controllers\UserController::class, 'showPermissions'])
            ->middleware('permission:user.view')
            ->name('users.show.permissions');

    });
    // Roles & Permissions
    Route::prefix('roles')->group(function () {
        Route::get('/', [\App\Http\Controllers\RoleController::class, 'index'])
            ->middleware('permission:role.view')
            ->name('roles.index');

        Route::get('/create', [\App\Http\Controllers\RoleController::class, 'create'])
            ->middleware('permission:role.create')
            ->name('roles.create');
        Route::post('/store', [\App\Http\Controllers\RoleController::class, 'store'])
            ->middleware('permission:role.create')
            ->name('roles.store');
        Route::get('/edit/{role}', [\App\Http\Controllers\RoleController::class, 'edit'])
            ->middleware('permission:role.edit')
            ->name('roles.edit');
        Route::put('/update/{role}', [\App\Http\Controllers\RoleController::class, 'update'])
            ->middleware('permission:role.edit')
            ->name('roles.update');
        Route::delete('/delete/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
            ->middleware('permission:role.delete')
            ->name('roles.destroy');

        // Permission Matrix
        Route::get('/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'editPermissions'])
            ->middleware('permission:role.edit')
            ->name('roles.permissions.edit');
        Route::post('/{role}/permissions', [\App\Http\Controllers\RoleController::class, 'updatePermissions'])
            ->middleware('permission:role.edit')
            ->name('roles.permissions.update');
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [\App\Http\Controllers\PermissionController::class, 'index'])
            ->middleware('permission:role.view')
            ->name('permissions.index');

        Route::get('/create', [\App\Http\Controllers\PermissionController::class, 'create'])
            ->middleware('permission:role.create')
            ->name('permissions.create');
        Route::post('/store', [\App\Http\Controllers\PermissionController::class, 'store'])
            ->middleware('permission:role.create')
            ->name('permissions.store');

        Route::get('/edit/{permission}', [\App\Http\Controllers\PermissionController::class, 'edit'])
            ->middleware('permission:role.edit')
            ->name('permissions.edit');
        Route::put('/update/{permission}', [\App\Http\Controllers\PermissionController::class, 'update'])
            ->middleware('permission:role.edit')
            ->name('permissions.update');
        Route::delete('/delete/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])
            ->middleware('permission:role.delete')
            ->name('permissions.destroy');

        Route::get('/{permission}/assign-role', [\App\Http\Controllers\PermissionController::class, 'assignRole'])
            ->middleware('permission:role.edit')
            ->name('permissions.assignRole');
        Route::post('/{permission}/assign-role', [\App\Http\Controllers\PermissionController::class, 'assignRoleStore'])
            ->middleware('permission:role.edit')
            ->name('permissions.assignRoleStore');
    });

        //category, brand, material
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->names([
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'show' => 'categories.show',
            'destroy' => 'categories.destroy',
        ]);
        Route::resource('brands', \App\Http\Controllers\BrandController::class)->names([
            'index' => 'brands.index',
            'create' => 'brands.create',
            'store' => 'brands.store',
            'edit' => 'brands.edit',
            'update' => 'brands.update',
            'destroy' => 'brands.destroy',
        ]);
        Route::resource('materials', \App\Http\Controllers\MaterialController::class)
            ->names([
                'index' => 'materials.index',
                'create' => 'materials.create',
                'store' => 'materials.store',
                'edit' => 'materials.edit',
                'update' => 'materials.update',
                'destroy' => 'materials.destroy',
                ]);
        //color, size
        Route::resource('colors', \App\Http\Controllers\ColorController::class)
            ->names([
                'index' => 'colors.index',
                'create' => 'colors.create',
                'store' => 'colors.store',
                'edit' => 'colors.edit',
                'update' => 'colors.update',
                'destroy' => 'colors.destroy',
            ]);
        Route::resource('sizes', \App\Http\Controllers\SizeController::class)
            ->names([
                'index' => 'sizes.index',
                'create' => 'sizes.create',
                'store' => 'sizes.store',
                'edit' => 'sizes.edit',
                'update' => 'sizes.update',
                'destroy' => 'sizes.destroy',
            ]);
        // Promotions
        Route::resource('promotions', \App\Http\Controllers\PromotionController::class)
            ->names([
                'index' => 'promotions.index',
                'create' => 'promotions.create',
                'store' => 'promotions.store',
                'edit' => 'promotions.edit',
                'update' => 'promotions.update',
                'destroy' => 'promotions.destroy',
            ]);
        // Order Status
        Route::resource('order-status', \App\Http\Controllers\OrderStatusController::class)
            ->names([
                'index' => 'order-status.index',
                'create' => 'order-status.create',
                'store' => 'order-status.store',
                'edit' => 'order-status.edit',
                'update' => 'order-status.update',
                'destroy' => 'order-status.destroy',
            ]);

            // Products
        Route::prefix('products')->group(function () {
            Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])
                ->name('products.index');
            Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])
                ->name('products.create');
            Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])
                ->name('products.store');
            Route::get('/show/{product}', [\App\Http\Controllers\ProductController::class, 'show'])
                ->name('products.show');
            Route::put('/update/{product}', [\App\Http\Controllers\ProductController::class, 'update'])
                ->name('products.update');
            //
            Route::delete('/variants/{productVariant}', [\App\Http\Controllers\ProductVariantController::class, 'destroy'])
                ->name('products.variants.destroy');
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

        // Duyệt đánh giá sản phẩm
        Route::prefix('reviews')->group(function () {
            Route::get('/', [\App\Http\Controllers\ReviewController::class, 'adminIndex'])
                ->name('reviews.index');
            Route::post('/{review}/approve', [\App\Http\Controllers\ReviewController::class, 'approve'])
                ->name('reviews.approve');
            Route::delete('/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])
                ->name('reviews.destroy');
        });

        // Liên hệ (Contact Us)
        Route::prefix('contacts')->group(function () {
            Route::get('/', [\App\Http\Controllers\ContactController::class, 'adminIndex'])
                ->name('contacts.index');
            Route::get('/{contact}', [\App\Http\Controllers\ContactController::class, 'adminShow'])
                ->name('contacts.show');
            Route::delete('/{contact}', [\App\Http\Controllers\ContactController::class, 'destroy'])
                ->name('contacts.destroy');
        });

});







