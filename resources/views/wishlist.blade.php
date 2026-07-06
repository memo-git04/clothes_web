@extends('layouts.app')
@section('content')
<div class="w-full bg-white text-black min-h-screen">
    <main class="pt-10 pb-10">
        <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10">

            <nav class="mb-2">
                <div class="flex items-center gap-3 text-[11px] tracking-[0.2em] uppercase text-neutral-400">
                    <a href="{{ route('home') }}" class="hover:text-black transition-colors">Trang chủ</a>
                    <span>/</span>
                    <span class="text-black">Sản phẩm yêu thích</span>
                </div>
            </nav>

            @if(session('success'))
                <div class="mb-8 text-center text-sm text-emerald-700 bg-emerald-50 border border-emerald-100 py-3">{{ session('success') }}</div>
            @endif

            @if($wishlists->count() > 0)
                <div class="border-b border-neutral-100 pb-10">
                    <div class="text-center space-y-4">
                        <h1 class="font-italic text-4xl md:text-5xl tracking-tight text-black italic">Sản phẩm yêu thích của tôi</h1>
                        <p class="text-neutral-500 text-xs tracking-[0.15em] uppercase">
                            {{ $wishlists->count() }} {{ $wishlists->count() === 1 ? 'sản phẩm' : 'sản phẩm' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-6 lg:gap-8">
                    @foreach($wishlists as $item)
                        @php
                            $variant = $item->variant;
                            $product = $variant?->product;
                            $img = $variant && $variant->images->count()
                                ? asset('storage/' . ($variant->images->firstWhere('is_main', 1)?->image_url ?? $variant->images->first()->image_url))
                                : asset('storage/default.jpg');
                        @endphp
                        <article class="flex flex-col group relative">
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST"
                                  class="absolute top-4 right-4 z-10">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-2 bg-white/80 backdrop-blur-sm rounded-full text-neutral-400 hover:text-black transition-colors"
                                        aria-label="Remove item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>

                            <div class="mb-6 overflow-hidden bg-neutral-50 relative aspect-[3/4]">
                                <a href="{{ $product ? route('product.detail', $product->id) : '#' }}">
                                    <img src="{{ $img }}" alt="{{ $product->product_name ?? '' }}"
                                         class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-105"/>
                                </a>
                                <div class="absolute inset-x-4 bottom-4 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    @if($variant)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                    class="w-full block text-center bg-black text-white text-[10px] tracking-[0.2em] uppercase py-3 hover:bg-neutral-800 transition-colors font-medium shadow-sm">
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="font-sans text-[10px] tracking-widest text-neutral-400 uppercase">{{ $product->category->category_name ?? '' }}</p>
                                <h3 class="font-italic text-lg tracking-tight text-black">
                                    <a href="{{ $product ? route('product.detail', $product->id) : '#' }}" class="hover:text-neutral-600 transition-colors">{{ $product->product_name ?? 'N/A' }}</a>
                                </h3>
                                <div class="flex items-center justify-between pt-1">
                                    <p class="font-italic text-sm text-neutral-900">{{ number_format($variant->selling_price ?? 0) }}đ</p>
                                    <span class="text-[9px] tracking-widest uppercase font-medium {{ ($variant->stock_quantity ?? 0) > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ ($variant->stock_quantity ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="flex justify-center mt-20 pt-12 border-t border-neutral-100">
                    <a href="{{ route('shop') }}" class="text-xs tracking-[0.2em] uppercase text-black hover:text-neutral-400 transition-colors pb-1 border-b border-black">
                        Tiếp tục mua sắm
                    </a>
                </div>
            @else
                <div class="text-center py-24 max-w-md mx-auto space-y-6">
                    <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mx-auto text-neutral-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h2 class="font-serif text-2xl text-black italic">Danh sách yêu thích trống</h2>
                        <p class="text-neutral-500 text-sm leading-relaxed font-sans">Lưu những sản phẩm bạn yêu thích tại đây.</p>
                    </div>
                    <div class="pt-4">
                        <a href="{{ route('shop') }}" class="inline-block bg-black text-white text-[10px] tracking-[0.2em] uppercase px-10 py-4 hover:bg-neutral-800 transition-colors font-medium">
                            Quay lại cửa hàng
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </main>
</div>
<style>
    .font-serif { font-family: 'Playfair Display', serif; }
    [x-cloak] { display: none !important; }
</style>
@endsection
