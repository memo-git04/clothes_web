@extends('layouts.app')

@section('content')
    @php
        $variant = $product->variants->first();
        $approvedReviews = $product->reviews->where('is_approved', true);
        $reviewCount = $approvedReviews->count();
        $avgRating = $reviewCount ? round($approvedReviews->avg('rating'), 1) : 0;
    @endphp
    <main class="max-w-[1440px] mx-auto px-4 md:px-8 lg:px-12 py-10" style="margin-top: 20px"
          x-data="productData({{ $product->variants->toJson() }})">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-[10px] tracking-[0.2em] uppercase text-gray-400 mb-8">
            <a href="/" class="hover:text-black">trang chủ</a>
            <span>/</span>
            <a href="/shop" class="hover:text-black">cửa hàng</a>
            <span>/</span>
            <a href="#" class="hover:text-black">{{ $product->category->category_name ?? '' }}</a>
            <span>/</span>
            <span class="text-black italic">{{ $product->product_name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            <!-- Bên trái: Ảnh sản phẩm (Chiếm 7 cột) -->

            <div class="lg:col-span-6">
                <div class="aspect-[4/5] bg-[#f5f5f5] overflow-hidden group relative">
                    <!-- Ảnh sẽ tự động hiển thị mặc định và thay đổi khi chọn màu/size -->
                    <img :src="selectedImageUrl" alt="Product Image" class="w-full h-full object-cover">

                    <!-- Badge (nếu có) -->
                    <div class="absolute top-6 left-6">
                        <span class="bg-black text-white text-[10px] tracking-widest uppercase px-3 py-1">bst mới</span>
                    </div>
                </div>
            </div>


            <!-- Bên phải: Thông tin sản phẩm (Chiếm 5 cột) -->
            <div class="lg:col-span-5 flex flex-col">
                <span class="text-[11px] tracking-[0.2em] uppercase text-gray-400 mb-2">{{ $product->category->category_name ?? '' }}</span>
                <h1 class="text-4xl font-light italic tracking-tight mb-4 text-[#1a1a1a]">{{ $product->product_name }}</h1>

                <!-- Đánh giá sao -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex text-black gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 fill-current {{ $i <= round($avgRating) ? 'text-black' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                    </div>
                    <span class="text-[10px] tracking-widest text-gray-400 uppercase">
                        {{ $reviewCount }} {{ $reviewCount === 1 ? 'đánh giá' : 'đánh giá' }}
                        @if($reviewCount) · {{ $avgRating }}/5 @endif
                    </span>
                </div>

                <!-- Giá tiền -->
                <div class="flex items-center gap-4 mb-8">
                    <span class="text-2xl text-black font-weight-bold font-light"
                          x-text="selectedPrice ? numberFormat(selectedPrice) + ' VNĐ' : ''">
                    </span>

                </div>

                <p class="text-sm text-gray-600 leading-relaxed mb-10 font-light">
                    {{ $product->description }}
                </p>

                <!-- Chọn màu (Color Selection) -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-medium uppercase tracking-[0.15em]">
                        màu: <span class="font-light text-gray-500" x-text="selectedColor"></span>
                    </span>
                    </div>
                    <div class="flex gap-3">
                        <template x-for="color in colors" :key="color">
                            <button
                                @click="selectColor(color)"
                                :class="selectedColor === color ? 'ring-2 ring-black' : 'border-gray-200'"
                                class="w-12 h-10 border flex items-center justify-center text-[10px] uppercase transition"
                                x-text="color"
                            ></button>
                        </template>
                    </div>
                </div>

                <!-- Chọn Size -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] font-medium uppercase tracking-[0.15em]">Size: <span class="font-light text-gray-400" x-text="selectedSize || 'Select a size'"></span></span>
                        <button  class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-200 hover:text-black transition">Size Guide</button>
                    </div>
                    <div class="grid grid-cols-5 gap-2">
                        <template x-for="size in sizes" :key="size">
                            <button
                                @click="selectSize(size)"
                                :class="selectedSize === size
                                ? 'bg-black text-white'
                                : 'bg-white text-black'"
                                class="h-12 border"
                                x-text="size"
                            ></button>
                        </template>
                    </div>
                </div>
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-medium uppercase tracking-[0.15em]">
                        Kho: <span class="font-light text-gray-500" x-text="selectedStock" ></span>
                    </span>
                    </div>
                </div>

                <!-- Số lượng & Nút mua -->
                <div class="flex flex-col gap-4">
                    <span class="text-[11px] font-medium uppercase tracking-[0.2em]">Số lượng</span>

                    <!-- Thông báo hết hàng -->
                    <div x-show="selectedVariantId && selectedStock <= 0" class="bg-red-50 text-red-600 text-sm px-4 py-3 border border-red-200 rounded-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        Sản phẩm hiện đang hết hàng
                    </div>

                    <!-- Lỗi số lượng -->
                    <div x-show="quantityError" class="bg-red-50 text-red-600 text-sm px-4 py-3 border border-red-200 rounded-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <span x-text="quantityError"></span>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Quantity -->
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-32"
                             :class="selectedStock <= 0 ? 'opacity-50 pointer-events-none' : ''">
                            <button @click="decrementQuantity()" :disabled="selectedStock <= 0" class="w-10 h-12 flex items-center justify-center text-xl font-light hover:bg-gray-100">-</button>
                            <input x-model="quantity" type="number" min="1" :max="selectedStock"
                                   class="w-12 text-center border-0 focus:outline-none text-lg font-light"
                                   @input="validateQuantity()">
                            <button @click="incrementQuantity()" :disabled="selectedStock <= 0" class="w-10 h-12 flex items-center justify-center text-xl font-light hover:bg-gray-100">+</button>
                        </div>

                        <!-- Buttons -->
                        <div class="flex-1 flex gap-3">
                            <!-- ADD TO CART -->
                            <button
                                @click="addToCart()"
                                :disabled="!canAddToCart"
                                :class="canAddToCart ? 'bg-black hover:bg-gray-800' : 'bg-gray-400 cursor-not-allowed'"
                                class="flex-1 text-white uppercase py-4 text-sm font-semibold transition">
                                <span x-text="selectedStock <= 0 ? 'HẾT HÀNG' : 'THÊM VÀO GIỎ HÀNG'"></span>
                            </button>

                            <!-- BUY NOW -->
                            <button
                                @click="buyNow()"
                                :disabled="!canAddToCart"
                                :class="canAddToCart ? 'bg-[#d97771] hover:bg-[#c56a63]' : 'bg-gray-400 cursor-not-allowed'"
                                class="flex-1 text-white uppercase py-4 text-sm font-semibold transition">
                                <span x-text="selectedStock <= 0 ? 'HẾT HÀNG' : 'MUA NGAY'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Wishlist Button - Đồng bộ kiểu mới -->
                    <div class="mt-3">
                        @auth
                            <button
                                @click="toggleWishlist()"
                                :disabled="!selectedVariantId || selectedStock <= 0"
                                :class="(!selectedVariantId || selectedStock <= 0)
                                    ? 'border-gray-300 text-gray-400 cursor-not-allowed'
                                    : 'border-black text-black hover:bg-black hover:text-white'"
                                class="w-full border uppercase py-3 text-xs tracking-[0.2em] font-medium transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span x-text="selectedStock <= 0 ? 'HẾT HÀNG' : 'THÊM VÀO YÊU THÍCH'"></span>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="w-full border border-gray-300 text-gray-500 uppercase py-3 text-xs tracking-[0.2em] font-medium hover:border-black hover:text-black transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                ĐĂNG NHẬP ĐỂ YÊU THÍCH
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-12 pt-8 border-t border-gray-100 space-y-4">
                    <div class="flex items-center gap-3 text-[10px] uppercase tracking-widest text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5"/></svg>
                        Free Shipping cho tất cả các đơn hàng
                    </div>
                    <div class="flex items-center gap-3 text-[10px] uppercase tracking-widest text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="1.5"/></svg>
                        hỗ trợ hoàn trả trong 30 ngày
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews section -->
        <section class="mt-24 border-t border-gray-100 pt-16">
            <h2 class="text-sm tracking-[0.2em] uppercase font-medium mb-10">
                Đánh giá sản phẩm ({{ $reviewCount }})
            </h2>
            @if($reviewCount === 0)
                <p class="text-gray-400 text-sm">Chưa có đánh giá nào cho sản phẩm này.</p>
            @else
                <div class="space-y-8 max-w-3xl">
                    @foreach($approvedReviews as $review)
                        <div class="border-b border-gray-100 pb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium">{{ $review->user->full_name ?? ($review->user->user_name ?? 'Khách hàng') }}</span>
                                <span class="text-[10px] text-gray-400">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex gap-0.5 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 fill-current {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="mt-24 border-t border-gray-100 pt-16">

            <div class="flex items-center justify-between mb-10">
                <h2 class="text-sm tracking-[0.2em] uppercase font-medium">Sản phẩm liên quan</h2>
                <a href="" class="text-[10px] tracking-[0.2em] uppercase text-gray-400 hover:text-black transition-colors border-b border-gray-200">View All</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-12">
                @foreach($relatedProducts as $item)
                    @php
                        $variant = $item->variants->first();
                        $image = $variant && $variant->images->count()
                                    ? $variant->images->first()->image_url
                                    : 'default.jpg';
                    @endphp
                    <div class="group">
                        <div class="relative group overflow-hidden aspect-[3/4]">
                            <img src="{{ asset('storage/' . $image) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="Product">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <a href="{{ route('product.detail', $item->id) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-serif text-sm font-light">
                                    {{ $item->product_name }}
                                </h3>
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">
                                    {{ $item->category->category_name ?? '' }}
                                </p>
                            </div>
                            <p class="text-xs font-light"> {{ number_format($variant->selling_price ?? 0) }}đ</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
    <script>
        function productData(variants) {
            return {
                variants: variants || [],
                selectedColor: '',
                selectedSize: '',
                selectedStock: 0,
                selectedVariantId: null,
                selectedPrice: 0,
                selectedBasePrice: 0,
                quantity: 1,
                quantityError: '',
                selectedImageUrl: '{{ asset("images/no-image.png") }}',

                get canAddToCart() {
                    return !!this.selectedVariantId && this.selectedStock > 0 && this.quantity >= 1 && !this.quantityError;
                },

                init() {
                    if (this.variants.length > 0) {
                        const first = this.variants[0];
                        if (first.color?.color_name) this.selectColor(first.color.color_name);
                    }
                },

                get colors() {
                    return [...new Set(this.variants.map(v => v.color?.color_name).filter(Boolean))];
                },

                get sizes() {
                    return this.variants
                        .filter(v => v.color?.color_name === this.selectedColor)
                        .map(v => v.size?.size_name)
                        .filter(Boolean);
                },

                numberFormat(price) {
                    return new Intl.NumberFormat('vi-VN').format(price);
                },
                addToCart() {
                    if (!this.canAddToCart) return;

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("cart.add") }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const variantInput = document.createElement('input');
                    variantInput.type = 'hidden';
                    variantInput.name = 'variant_id';
                    variantInput.value = this.selectedVariantId;
                    form.appendChild(variantInput);

                    const qtyInput = document.createElement('input');
                    qtyInput.type = 'hidden';
                    qtyInput.name = 'quantity';
                    qtyInput.value = this.quantity;
                    form.appendChild(qtyInput);

                    document.body.appendChild(form);
                    form.submit();
                },

                buyNow() {
                    if (!this.canAddToCart) {
                        if (this.quantity > this.selectedStock) {
                            this.quantityError = `Chỉ còn ${this.selectedStock} sản phẩm!`;
                        }
                        return;
                    }

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("buy.now") }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const variantInput = document.createElement('input');
                    variantInput.type = 'hidden';
                    variantInput.name = 'variant_id';
                    variantInput.value = this.selectedVariantId;
                    form.appendChild(variantInput);

                    const qtyInput = document.createElement('input');
                    qtyInput.type = 'hidden';
                    qtyInput.name = 'quantity';
                    qtyInput.value = this.quantity;
                    form.appendChild(qtyInput);

                    document.body.appendChild(form);
                    form.submit();
                },

                toggleWishlist() {
                    if (!this.selectedVariantId || this.selectedStock <= 0) return;

                    // Add validation for quantity
                    if (this.quantity > this.selectedStock) {
                        this.quantityError = 'Số lượng vượt quá tồn kho!';
                        return;
                    }

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("wishlist.toggle") }}';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const variantInput = document.createElement('input');
                    variantInput.type = 'hidden';
                    variantInput.name = 'variant_id';
                    variantInput.value = this.selectedVariantId;
                    form.appendChild(variantInput);

                    document.body.appendChild(form);
                    form.submit();
                },

                selectColor(color) {
                    this.selectedColor = color;
                    this.selectedSize = '';
                    this.selectedStock = 0;
                    this.selectedVariantId = null;
                    this.selectedPrice = 0;
                    this.selectedBasePrice = 0;
                    this.quantity = 1;
                    this.quantityError = ''; // RESET LỖI KHI ĐỔI MÀU
                    const availableSizes = this.variants
                        .filter(v => v.color?.color_name === color);

                    if (availableSizes.length > 0) {
                        this.selectSize(availableSizes[0].size?.size_name);
                    }
                    const firstVariantOfColor = this.variants.find(v => v.color?.color_name === color);
                    if (firstVariantOfColor && firstVariantOfColor.images && firstVariantOfColor.images.length > 0) {
                        this.selectedImageUrl = '/storage/' + firstVariantOfColor.images[0].image_url;
                    } else {
                        this.selectedImageUrl = '{{ asset("images/no-image.png") }}';
                    }
                },

                selectSize(size) {
                    this.selectedSize = size;
                    this.quantityError = ''; // RESET LỖI KHI ĐỔI SIZE

                    const variant = this.variants.find(v =>
                        v.color?.color_name === this.selectedColor &&
                        v.size?.size_name === size
                    );

                    if (variant) {
                        this.selectedStock = variant.stock_quantity || 0;
                        this.selectedVariantId = variant.id;
                        this.selectedPrice = variant.selling_price;
                        this.selectedBasePrice = variant.base_price;
                        this.quantity = 1;

                        if (variant.images && variant.images.length > 0) {
                            this.selectedImageUrl = '/storage/' + variant.images[0].image_url;
                        } else {
                            this.selectedImageUrl = '{{ asset("images/no-image.png") }}';
                        }
                    } else {
                        this.selectedStock = 0;
                        this.selectedVariantId = null;
                        this.selectedPrice = 0;
                        this.selectedBasePrice = 0;
                        this.quantity = 1;
                        this.selectedImageUrl = '{{ asset("images/no-image.png") }}';
                    }
                },

                incrementQuantity() {
                    this.quantityError = ''; // Xóa lỗi cũ
                    if (this.quantity < this.selectedStock) {
                        this.quantity++;
                    } else {
                        // Nếu bấm + nhưng đã chạm giới hạn kho thì báo lỗi luôn
                        this.quantityError = 'Vượt quá số lượng kho!';
                    }
                },

                decrementQuantity() {
                    if (this.quantity > 1) {
                        this.quantity--;
                    }
                    this.quantityError = ''; // Xóa lỗi cũ
                },

                validateQuantity() {
                    // Chuyển sang kiểu số nếu người dùng nhập vào input
                    let qty = parseInt(this.quantity);

                    if (isNaN(qty) || qty < 1) {
                        this.quantity = 1;
                        this.quantityError = '';
                    } else if (qty > this.selectedStock) {
                        this.quantity = qty; // Giữ nguyên số họ gõ để họ xem, nhưng hiện lỗi đỏ
                        this.quantityError = 'Vượt quá số lượng kho! (Còn lại: ' + this.selectedStock + ')';
                    } else {
                        this.quantity = qty;
                        this.quantityError = ''; // Hợp lệ thì xóa lỗi
                    }
                }
            }
        }
    </script>

@endsection

