<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/code', function () {
    return bcrypt('1234567');
});

//admin - login/logout
Route::get('/login', [\App\Http\Controllers\Admin\DashboardController::class, 'login'])
    ->name('login');
Route::post('/login', [\App\Http\Controllers\Admin\DashboardController::class, 'loginProcess'])
    ->name('loginProcess');
Route::get('/logout', [\App\Http\Controllers\Admin\DashboardController::class, 'logout'])
    ->name('logout');
//admin - dashboard
Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard');


//CURD
//category
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])
    ->name('categories.create');
Route::post('/categories/store', [\App\Http\Controllers\CategoryController::class, 'store'])
    ->name('categories.store');
Route::get('/categories/edit/{category}', [\App\Http\Controllers\CategoryController::class, 'edit'])
    ->name('categories.edit');
Route::put('/categories/edit/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])
    ->name('categories.update');
Route::delete('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])
    ->name('categories.destroy');
//brand
Route::get('/brands', [\App\Http\Controllers\BrandController::class, 'index'])
    ->name('brands.index');
Route::get('/brands/create', [\App\Http\Controllers\BrandController::class, 'create'])
    ->name('brands.create');
Route::post('/brands/store', [\App\Http\Controllers\BrandController::class, 'store'])
    ->name('brands.store');
Route::get('/brands/edit/{brand}', [\App\Http\Controllers\BrandController::class, 'edit'])
    ->name('brands.edit');
Route::put('/brands/edit/{brand}', [\App\Http\Controllers\BrandController::class, 'update'])
    ->name('brands.update');
Route::delete('/brands/{brand}', [\App\Http\Controllers\BrandController::class, 'destroy'])
    ->name('brands.destroy');
//material
Route::prefix('/materials')->group(function () {
    Route::get('/', [\App\Http\Controllers\MaterialController::class, 'index'])
        ->name('materials.index');
    Route::get('/create', [\App\Http\Controllers\MaterialController::class, 'create'])
        ->name('materials.create');

    Route::post('/store', [\App\Http\Controllers\MaterialController::class, 'store'])
        ->name('materials.store');

    Route::get('/edit/{material}', [\App\Http\Controllers\MaterialController::class, 'edit'])
        ->name('materials.edit');
    Route::put('/edit/{material}', [\App\Http\Controllers\MaterialController::class, 'update'])
        ->name('materials.update');
    Route::delete('/{material}', [\App\Http\Controllers\MaterialController::class, 'destroy'])
        ->name('materials.destroy');
});
//color
Route::prefix('/colors')->group(function () {
    Route::get('/', [\App\Http\Controllers\ColorController::class, 'index'])
        ->name('colors.index');
    Route::get('/create', [\App\Http\Controllers\ColorController::class, 'create'])
        ->name('colors.create');
    Route::post('/store', [\App\Http\Controllers\ColorController::class, 'store'])
        ->name('colors.store');
    Route::get('/edit/{color}', [\App\Http\Controllers\ColorController::class, 'edit'])
        ->name('colors.edit');
    Route::put('/edit/{color}', [\App\Http\Controllers\ColorController::class, 'update'])
        ->name('colors.update');
    Route::delete('/{color}', [\App\Http\Controllers\ColorController::class, 'destroy'])
        ->name('colors.destroy');
});
//size
Route::prefix('/sizes')->group(function () {
    Route::get('/', [\App\Http\Controllers\SizeController::class, 'index'])
        ->name('sizes.index');
    Route::get('/create', [\App\Http\Controllers\SizeController::class, 'create'])
        ->name('sizes.create');
    Route::post('/store', [\App\Http\Controllers\SizeController::class, 'store'])
        ->name('sizes.store');
    Route::get('/edit/{size}', [\App\Http\Controllers\SizeController::class, 'edit'])
        ->name('sizes.edit');
    Route::put('/edit/{size}', [\App\Http\Controllers\SizeController::class, 'update'])
        ->name('sizes.update');
    Route::delete('/{size}', [\App\Http\Controllers\SizeController::class, 'destroy'])
        ->name('sizes.destroy');
});
//order_status
Route::prefix('/order-status')->group(function () {
    Route::get('/', [\App\Http\Controllers\OrderStatusController::class, 'index'])
        ->name('order-status.index');
    Route::get('/create', [\App\Http\Controllers\OrderStatusController::class, 'create'])
        ->name('order-status.create');
    Route::post('/store', [\App\Http\Controllers\OrderStatusController::class, 'store'])
        ->name('order-status.store');
});
//promotion
Route::prefix('/promotions')->group(function () {
    Route::get('/', [\App\Http\Controllers\PromotionController::class, 'index'])
        ->name('promotions.index');
    Route::get('/create', [\App\Http\Controllers\PromotionController::class, 'create'])
        ->name('promotions.create');
    Route::post('/store', [\App\Http\Controllers\PromotionController::class, 'store'])
        ->name('promotions.store');
    Route::get('/edit/{promotion}', [\App\Http\Controllers\PromotionController::class, 'edit'])
        ->name('promotions.edit');
    Route::put('/edit/{promotion}', [\App\Http\Controllers\PromotionController::class, 'update'])
        ->name('promotions.update');
    Route::delete('/{promotion}', [\App\Http\Controllers\PromotionController::class, 'destroy'])
        ->name('promotions.destroy');
});
//account
Route::prefix('admin/users')->group(function () {
    Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])
        ->name('admin.users.index');
    Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])
        ->name('admin.users.create');
    Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])
        ->name('admin.users.store');
    Route::get('/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])
        ->name('admin.users.edit');
    Route::put('/update/{user}', [\App\Http\Controllers\UserController::class, 'update'])
        ->name('admin.users.update');
    Route::delete('/delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])
        ->name('admin.users.destroy');
});
//product
Route::prefix('/products')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])
        ->name('products.index');
    Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/edit/{product}', [\App\Http\Controllers\ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/edit/{product}', [\App\Http\Controllers\ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])
        ->name('products.destroy');
});



Route::get('/home', function () {
    return view('home');
});

Route::get('/checkout', function () {
    return view('checkout'); // Đảm bảo tên file là checkout.blade.php
})->name('checkout.index');

// 2. Route xử lý dữ liệu khi người dùng nhấn "Pay Now" (Phương thức POST)
// Route này bắt buộc phải có để khớp với action="{{ route('checkout.store') }}"
Route::post('/checkout/store', function ($request) {
    // Logic xử lý thanh toán của bạn sẽ nằm ở đây
    return response()->json([
        'message' => 'Đơn hàng đang được xử lý!',
        'data' => $request->all()
    ]);
})->name('checkout.store');
Route::get('/shop', function () {
    // Giả lập dữ liệu hoặc lấy từ Database
    $products = [
        (object)['id' => 1, 'name' => 'Silk Drape Dress', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 2, 'name' => 'Wool Trousers', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 3, 'name' => 'Leather Jacket', 'price' => 600, 'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 4, 'name' => 'Cashmere Sweater', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 5, 'name' => 'Denim Jeans', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 6, 'name' => 'Silk Blouse', 'price' => 350, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 7, 'name' => 'Wool Coat', 'price' => 800, 'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 8, 'name' => 'Leather Boots', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 9, 'name' => 'Cashmere Scarf', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 10, 'name' => 'Denim Jacket', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
    ];

    return view('shop', ['products' => $products]);
});

Route::get('/shop_men', function () {
    // Giả lập dữ liệu hoặc lấy từ Database
    $products = [
        (object)['id' => 1, 'name' => 'Silk Drape Dress', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 2, 'name' => 'Wool Trousers', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 3, 'name' => 'Leather Jacket', 'price' => 600, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 4, 'name' => 'Cashmere Sweater', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 5, 'name' => 'Denim Jeans', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 6, 'name' => 'Silk Blouse', 'price' => 350, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 7, 'name' => 'Wool Coat', 'price' => 800, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 8, 'name' => 'Leather Boots', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 9, 'name' => 'Cashmere Scarf', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 10, 'name' => 'Denim Jacket', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200', 'category' => 'Limited', 'is_new' => false],
    ];

    return view('shop_men', ['products' => $products]);
});
Route::get('/shop_women', function () {
    // Giả lập dữ liệu hoặc lấy từ Database
    $products = [
        (object)['id' => 1, 'name' => 'Silk Drape Dress', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 2, 'name' => 'Wool Trousers', 'price' => 320, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 3, 'name' => 'Leather Jacket', 'price' => 600, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 4, 'name' => 'Cashmere Sweater', 'price' => 280, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 5, 'name' => 'Denim Jeans', 'price' => 150, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 6, 'name' => 'Silk Blouse', 'price' => 350, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 7, 'name' => 'Wool Coat', 'price' => 800, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 8, 'name' => 'Leather Boots', 'price' => 450, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Limited', 'is_new' => false],
        (object)['id' => 9, 'name' => 'Cashmere Scarf', 'price' => 120, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Ready-to-wear', 'is_new' => true],
        (object)['id' => 10, 'name' => 'Denim Jacket', 'price' => 200, 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200', 'category' => 'Limited', 'is_new' => false],
    ];

    return view('shop_women', ['products' => $products]);
});

Route::get('/product/{id}', function ($id) {
    // Trong thực tế, ông sẽ dùng: $product = Product::findOrFail($id);
    // Ở đây tôi giả lập lấy dữ liệu theo ID
    $products = collect([
        (object)[
            'id' => 1,
            'name' => 'Oversized Pea Blazer',
            'price' => 245,
            'old_price' => 295,
            'category' => 'Jackets',
            'description' => 'An oversized pea blazer crafted from premium wool blend fabric...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Black', 'Navy', 'Tan'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
        (object)[
            'id' => 2,
            'name' => 'Silk Drape Dress',
            'price' => 450,
            'old_price' => null,
            'category' => 'Ready-to-wear',
            'description' => 'A luxurious silk drape dress that flows elegantly with every step...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Red', 'Emerald', 'Sapphire'],
            'sizes' => ['XS', 'S', 'M', 'L']
        ],
         (object)[
            'id' => 3,
            'name' => 'Wool Trousers',
            'price' => 320,
            'old_price' => 350,
            'category' => 'Limited',
            'description' => 'Tailored wool trousers that combine comfort and sophistication...',
            'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200',
            'colors' => ['Gray', 'Charcoal', 'Navy'],
            'sizes' => ['28', '30', '32', '34', '36']
        ],
         (object)[
            'id' => 4,
            'name' => 'Leather Jacket',
            'price' => 600,
            'old_price' => null,
            'category' => 'Ready-to-wear',
            'description' => 'A classic leather jacket made from premium materials for a timeless look...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Black', 'Brown', 'Burgundy'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
         (object)[
            'id' => 5,
            'name' => 'Cashmere Sweater',
            'price' => 280,
            'old_price' => 320,
            'category' => 'Limited',
            'description' => 'A soft cashmere sweater that provides warmth and style during colder months   ...',
            'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200',
            'colors' => ['Beige', 'Cream', 'Light Gray'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
            (object)[
            'id' => 6,
            'name' => 'Oversized Pea Blazer',
            'price' => 245,
            'old_price' => 295,
            'category' => 'Jackets',
            'description' => 'An oversized pea blazer crafted from premium wool blend fabric...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Black', 'Navy', 'Tan'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
        (object)[
            'id' => 7,
            'name' => 'Silk Drape Dress',
            'price' => 450,
            'old_price' => null,
            'category' => 'Ready-to-wear',
            'description' => 'A luxurious silk drape dress that flows elegantly with every step...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Red', 'Emerald', 'Sapphire'],
            'sizes' => ['XS', 'S', 'M', 'L']
        ],
         (object)[
            'id' => 8,
            'name' => 'Wool Trousers',
            'price' => 320,
            'old_price' => 350,
            'category' => 'Limited',
            'description' => 'Tailored wool trousers that combine comfort and sophistication...',
            'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200',
            'colors' => ['Gray', 'Charcoal', 'Navy'],
            'sizes' => ['28', '30', '32', '34', '36']
        ],
         (object)[
            'id' => 9,
            'name' => 'Leather Jacket',
            'price' => 600,
            'old_price' => null,
            'category' => 'Ready-to-wear',
            'description' => 'A classic leather jacket made from premium materials for a timeless look...',
            'image' => 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200',
            'colors' => ['Black', 'Brown', 'Burgundy'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
         (object)[
            'id' => 10,
            'name' => 'Cashmere Sweater',
            'price' => 280,
            'old_price' => 320,
            'category' => 'Limited',
            'description' => 'A soft cashmere sweater that provides warmth and style during colder months   ...',
            'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200',
            'colors' => ['Beige', 'Cream', 'Light Gray'],
            'sizes' => ['XS', 'S', 'M', 'L', 'XL']
        ],
    ]);

    $product = $products->firstWhere('id', $id);

    if (!$product) abort(404);

    return view('product_details', ['product' => $product]);
})->name('product.details');

Route::get('/cart', function () {
    // Giả lập dữ liệu giỏ hàng từ Session hoặc DB
    $cartItems = [
        [
            'id' => '1',
            'name' => 'Oversized Pea Blazer in Black',
            'price' => 245,
            'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80',
            'size' => 'M',
            'color' => 'Black',
            'quantity' => 1,
        ],
        // ... các item khác
    ];
    return view('cart')->with('cartItems', $cartItems);
});

Route::get('/blog', function () {
    $blogPosts = [
        ['id' => 1, 'title' => 'The Art of Minimalist Tailoring', 'slug' => 'art-minimalist-tailoring', 'category' => 'Editorial', 'excerpt' => '...', 'date' => 'May 12, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
        ['id' => 2, 'title' => 'The Future of Sustainable Fashion', 'slug' => 'future-sustainable-fashion', 'category' => 'Sustainability', 'excerpt' => '...', 'date' => 'June 15, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
        ['id' => 3, 'title' => 'The Art of Minimalist Tailoring', 'slug' => 'art-minimalist-tailoring', 'category' => 'Editorial', 'excerpt' => '...', 'date' => 'May 12, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
        ['id' => 4, 'title' => 'The Future of Sustainable Fashion', 'slug' => 'future-sustainable-fashion', 'category' => 'Sustainability', 'excerpt' => '...', 'date' => 'June 15, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
        ['id' => 5, 'title' => 'The Art of Minimalist Tailoring', 'slug' => 'art-minimalist-tailoring', 'category' => 'Editorial', 'excerpt' => '...', 'date' => 'May 12, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
        ['id' => 6, 'title' => 'The Future of Sustainable Fashion', 'slug' => 'future-sustainable-fashion', 'category' => 'Sustainability', 'excerpt' => '...', 'date' => 'June 15, 2026', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'],
    ];
    return view('blog', compact('blogPosts'));
});
Route::get('/wishlist', function () {
    // Giả lập dữ liệu để file Blade không bị lỗi
    $wishlistItems = [
        [
            'id' => 'prod-1',
            'name' => 'Signature Trench Coat',
            'slug' => 'signature-trench-coat',
            'category' => 'Outerwear',
            'price' => '1,250',
            'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop',
            'in_stock' => true
        ],
        [
            'id' => 'prod-2',
            'name' => 'Classic Wool Blazer',
            'slug' => 'classic-wool-blazer',
            'category' => 'Suiting',
            'price' => '890',
            'image' => 'https://images.unsplash.com/photo-1548624149-f9b1859aa702?q=80&w=600&auto=format&fit=crop',
            'in_stock' => false // Sẽ hiện Low Stock
        ],
        [
            'id' => 'prod-3',
            'name' => 'Silk Slip Dress',
            'slug' => 'silk-slip-dress',
            'category' => 'Dresses',
            'price' => '650',
            'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
            'in_stock' => true
        ],
           [
            'id' => 'prod-4',
            'name' => 'Silk Slip Dress',
            'slug' => 'silk-slip-dress',
            'category' => 'Dresses',
            'price' => '650',
            'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
            'in_stock' => true
        ]
    ];

    return view('wishlist', compact('wishlistItems'));
});

Route::get('/contactus', function () {
    return view('contactus');
})->name('contactus');


