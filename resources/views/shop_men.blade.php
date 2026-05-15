@extends('layouts.app')
@section('content')
<main class="pt-[120px] min-h-screen" x-data="{ filtersOpen: false, sortOpen: false, gridCols: 3 }">
    <div class="bg-[#F5F5F0]"> <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10 py-12 lg:py-20">
            <nav class="mb-4">
                <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-gray-500">
                    <li><a href="/" class="hover:text-black transition-colors">Home</a></li>
                    <li>/</li>
                    <li class="text-black">Men-Shop</li>
                </ol>
            </nav>
            <h1 class="font-serif text-4xl lg:text-5xl font-light tracking-tight text-black">
                Men's Products
            </h1>
            <p class="mt-4 text-gray-500 max-w-xl">
                Discover our complete collection of timeless fashion pieces, carefully curated for the modern wardrobe.
            </p>
        </div>
    </div>

    <div class="border-b border-gray-100 sticky top-[80px] bg-white z-30">
        <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10">
            <div class="flex items-center justify-between h-14">
                <button @click="filtersOpen = true" class="lg:hidden flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                    Filters
                </button>

                <p class="hidden lg:block text-sm text-gray-500">
                    Showing <span class="text-black">{{ count($products) }}</span> products
                </p>

                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button @click="sortOpen = !sortOpen" @click.away="sortOpen = false" class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase">
                            Sort: <span x-text="selectedSortLabel || 'Featured'"></span>
                            <svg :class="sortOpen ? 'rotate-180' : ''" class="h-3.5 w-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="sortOpen" class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 shadow-lg z-50">
                            @foreach(['featured' => 'Featured', 'newest' => 'Newest', 'price-asc' => 'Price: Low to High', 'price-desc' => 'Price: High to Low'] as $value => $label)
                                <button class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="hidden lg:flex items-center gap-1 border-l border-gray-100 pl-4">
                        <button @click="gridCols = 2" :class="gridCols === 2 ? 'text-black' : 'text-gray-400'" class="p-1.5 transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 00-1-1H5zM11 4a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 00-1-1h-2zM4 11a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2zM11 10a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 00-1-1h-2z"></path></svg>
                        </button>
                        <button @click="gridCols = 3" :class="gridCols === 3 ? 'text-black' : 'text-gray-400'" class="p-1.5 transition-colors">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm2 0v12h12V4H4z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
        <div class="lg:flex lg:gap-10"> <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-[150px]"> <h2 class="text-[12px] uppercase tracking-[0.2em] font-bold mb-8">Categories</h2>
                    
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-[15px] uppercase tracking-widest text-black font-semibold mb-4 border-b border-gray-400 pb-2">Men</h3>
                            <ul class="space-y-3">
                                @foreach(['Jean', 'Hoodie', 'T-Shirt', 'Trousers', 'Suit'] as $item)
                                    <li><a href="#" class="text-sm text-gray-500 hover:text-black transition-colors">{{ $item }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-[15px] uppercase tracking-widest text-black font-semibold mb-4 border-b border-gray-400 pb-2">Women</h3>
                            <ul class="space-y-3">
                                @foreach(['Jean', 'Hoodie', 'T-Shirt', 'Dress'] as $item)
                                    <li><a href="#" class="text-sm text-gray-500 hover:text-black transition-colors">{{ $item }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>
    <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
        <div class="lg:flex lg:gap-12">
            <aside class="hidden lg:block w-64 flex-shrink-0">
                {{--@include('partials.shop-filters')--}}
            </aside>

            <div class="flex-1">
                <div :class="gridCols === 2 ? 'grid-cols-1 sm:grid-cols-2' : 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3'" class="grid gap-x-6 gap-y-12">
                    @foreach($products as $product)
                        <div class="group">
                            <div class="relative aspect-[3/4] overflow-hidden bg-gray-50 mb-4">
                                @if($product->is_new)
                                    <span class="absolute top-4 left-4 z-10 px-2 py-1 bg-black text-white text-[9px] tracking-widest uppercase">New</span>
                                @endif

                                <img src="{{ $product->image }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                
                                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3">
                                    <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                    <a href="/product/{{ $product->id }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-[9px] tracking-[0.15em] uppercase text-gray-400 mb-1">{{ $product->category }}</p>
                                    <h3 class="text-[13px] font-serif tracking-wide mb-1">{{ $product->name }}</h3>
                                </div>
                                <p class="text-sm font-light text-gray-900">${{ $product->price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

              {{--  <div class="mt-16 flex items-center justify-center gap-2">
                    {{ $products->links() }} </div>--}}
            </div>
        </div>
    </div>
</main>
@endsection