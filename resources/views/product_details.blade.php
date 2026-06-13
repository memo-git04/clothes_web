@extends('layouts.app')

{{--<pre>{{ json_encode($product->variants, JSON_PRETTY_PRINT) }}</pre>--}}
@section('content')
    @php
        $variant = $product->variants->first();
    @endphp
<main class="max-w-[1440px] mx-auto px-4 md:px-8 lg:px-12 py-10"
      x-data="productData({{ $product->variants->toJson() }})">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-[10px] tracking-[0.2em] uppercase text-gray-400 mb-8">
        <a href="/" class="hover:text-black">Home</a>
        <span>/</span>
        <a href="/shop" class="hover:text-black">Shop</a>
        <span>/</span>
        <a href="#" class="hover:text-black">{{ $product->category->category_name ?? '' }}</a>
        <span>/</span>
        <span class="text-black italic">{{ $product->product_name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
        <!-- Bên trái: Ảnh sản phẩm (Chiếm 7 cột) -->

        <div class="lg:col-span-7">
            <div class="aspect-[4/5] bg-[#f5f5f5] overflow-hidden group relative">
                <!-- Thay ảnh placeholder bằng ảnh thật từ DB của ông -->
                @if($product->variants->first() && $product->variants->first()->images->first())
                    <img src="{{ asset('storage/' . $product->variants->first()->images->first()->image_url) }}" alt="Product Image" class="w-full h-full object-cover">
                @endif
                <!-- Badge (nếu có) -->
                <div class="absolute top-6 left-6">
                    <span class="bg-black text-white text-[10px] tracking-widest uppercase px-3 py-1">New Collection</span>
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
                    @for($i=0; $i<4; $i++)
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    @endfor
                    <svg class="w-3.5 h-3.5 text-gray-200 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                </div>
                <span class="text-[10px] tracking-widest text-gray-400 uppercase">12 reviews</span>
            </div>

            <!-- Giá tiền -->
            <div class="flex items-center gap-4 mb-8">
                <span class="text-2xl text-[#d97771] font-light">{{ number_format($variant->selling_price ?? 0) }} VNĐ</span>
                <span class="text-lg text-gray-300 line-through font-light">{{ number_format($variant->base_price ?? 0) }} VNĐ</span>
                <span class="px-2 py-0.5 bg-[#fdf2f2] text-[#d97771] text-[10px] tracking-wider uppercase">Save $50</span>
            </div>

            <p class="text-sm text-gray-600 leading-relaxed mb-10 font-light">
                An oversized pea blazer crafted from premium wool blend fabric. Features double-breasted front with statement buttons, notched lapels, and a relaxed fit that layers beautifully over knitwear and tailored pieces.
            </p>

            <!-- Chọn màu (Color Selection) -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-medium uppercase tracking-[0.15em]">
                        Color: <span class="font-light text-gray-500" x-text="selectedColor"></span>
                    </span>
                </div>
                <div class="flex gap-3">
                    <template x-for="color in colors" :key="color">
                        <button
                            @click="selectColor(color)"
                            :class="selectedColor === color ? 'ring-2 ring-black' : ''"
                            class="w-8 h-8 border"
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
                        Stock: <span class="font-light text-gray-500" x-text="selectedStock" ></span>
                    </span>
                </div>
            </div>

            <!-- Số lượng & Nút mua -->
            <div class="flex flex-col gap-4">
                <span class="text-[11px] font-medium uppercase tracking-[0.15em]">Quantity</span>
                <div class="flex gap-4">
                    <div class="relative w-24">
                        <select x-model="quantity">
                            <template x-for="i in selectedStock > 0 ? selectedStock : 0">
                                <option :value="i" x-text="i"></option>
                            </template>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <form action="{{route('cart.add') }}" method="POST">
                        @csrf

                        <input type="hidden" name="variant_id" :value="selectedVariantId">
                        <input type="hidden" name="quantity" :value="quantity">

                        <button
                            type="submit"
                            :disabled="!selectedVariantId"
                            class="flex-1 bg-black text-white uppercase">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 pt-8 border-t border-gray-100 space-y-4">
                <div class="flex items-center gap-3 text-[10px] uppercase tracking-widest text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5"/></svg>
                    Free Shipping on orders over $150
                </div>
                <div class="flex items-center gap-3 text-[10px] uppercase tracking-widest text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="1.5"/></svg>
                    30-day easy returns
                </div>
            </div>
        </div>
    </div>

    <section class="mt-24 border-t border-gray-100 pt-16">

        <div class="flex items-center justify-between mb-10">
            <h2 class="text-sm tracking-[0.2em] uppercase font-medium">You Might Also Like</h2>
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
                variants: variants,
                selectedColor: '',
                selectedSize: '',
                selectedStock: 0,
                selectedVariantId: null,
                quantity: 1,

                get colors() {
                    return [...new Set(this.variants.map(v => v.color?.color_name))];
                },

                get sizes() {
                    return this.variants
                        .filter(v => v.color?.color_name === this.selectedColor)
                        .map(v => v.size?.size_name);
                },

                selectColor(color) {
                    this.selectedColor = color;
                    this.selectedSize = '';
                    this.selectedStock = 0;
                    this.selectedVariantId = null;
                },

                selectSize(size) {
                    this.selectedSize = size;

                    let variant = this.variants.find(v =>
                        v.color?.color_name === this.selectedColor &&
                        v.size?.size_name === size
                    );

                    if (variant) {
                        this.selectedStock = variant.stock_quantity;
                        this.selectedVariantId = variant.id;
                        this.quantity = 1;
                    } else {
                        this.selectedStock = 0;
                        this.selectedVariantId = null;
                        this.quantity = 0;
                    }
                },

            }
        }
    </script>
@endsection
