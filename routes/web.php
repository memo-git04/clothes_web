<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
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
Route::get('/contactus', function () {
    return view('contactus');
});
