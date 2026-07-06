@extends('layouts.app')
@section('content')
<main class="min-h-screen"
      x-data="{
      sortOpen: false,
        openCategories: [],
        toggleCategory(id) {
            const index = this.openCategories.indexOf(id);
            if (index === -1) {
                this.openCategories.push(id);
            } else {
                this.openCategories.splice(index, 1);
            }
        }
      }">
    <!-- Hero -->
    <div class="bg-[#F5F5F0]">
        <div class="mx-auto max-w-[1800px]  sm:px-6 lg:px-10  lg:py-16">
            <nav class="mb-4">
                <ol class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-black transition-colors">Trang chủ</a></li>
                    <li>/</li>
                    <li class="text-black">{{ $title }}</li>
                </ol>
            </nav>
            <h1 class="font-tiny text-4xl lg:text-5xl font-light tracking-tight text-black">{{ $title }}</h1>
            @if(!empty($q))
                <p class="mt-4 text-gray-500">Từ khóa: <span class="text-black font-medium">"{{ $q }}"</span></p>
            @endif

            <!-- Search form -->
            <form action="{{ route('search') }}" method="GET" class="mt-6 max-w-md flex">
                <input type="text" name="q" value="{{ $q }}" placeholder="Tìm sản phẩm..."
                       class="flex-1 bg-white border border-gray-200 py-2.5 px-4 text-sm focus:outline-none focus:border-black">
                <button type="submit" class="px-6 bg-black text-white text-[11px] uppercase tracking-[0.2em] hover:opacity-80 transition">Tìm</button>
            </form>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10">
            <div class="flex items-center justify-between h-14">
                <p class="text-sm text-gray-500">
                    Hiển thị <span class="text-black">{{ $products->total() }}</span> sản phẩm
                </p>
                <div class="relative">
                    <button @click="sortOpen = !sortOpen" @click.away="sortOpen = false"
                            class="flex items-center gap-2 text-[11px] tracking-[0.15em] uppercase">
                        Sắp xếp:
                        <span>{{ ['featured'=>'Nổi bật','newest'=>'Mới nhất','price-asc'=>'Giá tăng','price-desc'=>'Giá giảm'][$sort] ?? 'Nổi bật' }}</span>
                        <svg :class="sortOpen ? 'rotate-180' : ''" class="h-3.5 w-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="sortOpen" x-cloak class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 shadow-lg z-50">
                        @foreach(['featured' => 'Nổi bật', 'newest' => 'Mới nhất', 'price-asc' => 'Giá: Thấp → Cao', 'price-desc' => 'Giá: Cao → Thấp'] as $value => $label)
                            <a href="{{ request()->fullUrlWithQuery(['sort' => $value, 'page' => 1]) }}"
                               class="block px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors {{ $sort === $value ? 'font-semibold text-black' : 'text-gray-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
        <div class="lg:flex lg:gap-10">
            <!-- Sidebar categories -->
            <aside class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-[150px]">
                    <h2 class="text-[12px] uppercase tracking-[0.2em] font-bold mb-6">Danh mục</h2>
                    <div class="space-y-3">
                        @foreach($categories as $category)
                            <div class="relative">
                                <!-- Parent category button -->
                                <button
                                    @click="toggleCategory({{ $category['id'] }})"
                                    class="w-full flex items-center justify-between text-sm transition-colors py-2 px-3 hover:bg-gray-50 rounded"
                                    :class="openCategories.includes({{ $category['id'] }}) ? 'text-black font-semibold' : 'text-gray-500 hover:text-black'"
                                >
                                    <span>{{ $category['name'] }}</span>
                                    <svg
                                        :class="openCategories.includes({{ $category['id'] }}) ? 'rotate-180' : ''"
                                        class="h-3 w-3 transform transition-transform duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Child categories dropdown -->
                                <div
                                    x-show="openCategories.includes({{ $category['id'] }})"
                                    x-cloak
                                    x-transition
                                    class="pl-4 mt-1 space-y-2"
                                >
                                    @foreach($category['children'] as $child)
                                        <div class="relative">
                                            <!-- Child category button -->
                                            <button
                                                @click="toggleCategory({{ $child['id'] }})"
                                                class="w-full flex items-center justify-between text-sm transition-colors py-2 px-3 hover:bg-gray-50 rounded"
                                                :class="openCategories.includes({{ $child['id'] }}) ? 'text-black font-semibold' : 'text-gray-500 hover:text-black'"
                                            >
                                                <span>{{ $child['name'] }}</span>
                                                <svg
                                                    :class="openCategories.includes({{ $child['id'] }}) ? 'rotate-180' : ''"
                                                    class="h-3 w-3 transform transition-transform duration-200"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>

                                            <!-- Grandchild categories dropdown -->
                                            <div
                                                x-show="openCategories.includes({{ $child['id'] }})"
                                                x-cloak
                                                x-transition
                                                class="pl-4 mt-1 space-y-2"
                                            >
                                                @foreach($child['children'] as $grandchild)
                                                    <a
                                                        href="{{ request()->fullUrlWithQuery(['category' => $grandchild['id'], 'page' => 1]) }}"
                                                        class="block text-sm transition-colors py-2 px-3 hover:bg-gray-50 rounded"
                                                        :class="(string){{ $activeCategoryId }} === (string){{ $grandchild['id'] }} ? 'text-black font-semibold' : 'text-gray-500 hover:text-black'"
                                                    >
                                                        {{ $grandchild['name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Brands Section -->
                    <h2 class="text-[12px] uppercase tracking-[0.2em] font-bold mb-6 mt-8">Thương hiệu</h2>
                    <form action="{{ route('search') }}" method="GET" class="mb-4">
                        <input type="hidden" name="q" value="{{ $q }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <input type="hidden"
                               name="brand"
                               value="{{ $activeBrandId ?? '' }}"
                               placeholder="Tìm thương hiệu..."
                               class="w-full bg-white border border-gray-200 py-2 px-3 text-sm focus:outline-none focus:border-black">
                        <button type="submit" class="hidden"></button>
                    </form>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['brand' => null, 'page' => 1]) }}"
                               class="text-sm transition-colors {{ empty($activeBrandId) ? 'text-black font-semibold' : 'text-gray-500 hover:text-black' }}">
                                Tất cả
                            </a>
                        </li>
                        @foreach($brands as $brand)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->id, 'page' => 1]) }}"
                                   class="text-sm transition-colors {{ (string)$activeBrandId === (string)$brand->id ? 'text-black font-semibold' : 'text-gray-500 hover:text-black' }}">
                                    {{ $brand->brand_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>


            <!-- Product grid -->
            <div class="flex-1">
                @if($products->count() === 0)
                    <div class="py-24 text-center text-gray-400">
                        <p class="text-lg">Không tìm thấy sản phẩm nào.</p>
                        <a href="{{ route('shop') }}" class="inline-block mt-4 text-[11px] uppercase tracking-[0.2em] underline">Xem tất cả sản phẩm</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12">
                        @foreach($products as $product)
                            @php $variant = $product->default_variant; @endphp
                            <div class="group">
                                <div class="relative aspect-[3/4] overflow-hidden bg-gray-50 mb-4">
                                    @if($product->is_new)
                                        <span class="absolute top-4 left-4 z-10 px-2 py-1 bg-black text-white text-[9px] tracking-widest uppercase">New</span>
                                    @endif
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <img src="{{ $product->main_image_url }}" alt="{{ $product->product_name }}"
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    </a>
                                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center gap-3 pb-4">
                                        @auth
                                            @if($variant)
                                                <form action="{{ route('wishlist.toggle') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                                    <button type="submit" title="Yêu thích"
                                                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                        @if($variant)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" title="Thêm vào giỏ"
                                                        class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" /></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-[9px] tracking-[0.15em] uppercase text-gray-400 mb-1">{{ $product->category->category_name ?? '' }}</p>
                                        <a href="{{ route('product.detail', $product->id) }}">
                                            <h3 class="text-[13px] font-serif tracking-wide mb-1 hover:text-gray-500 transition">{{ $product->product_name }}</h3>
                                        </a>
                                    </div>
                                    <p class="text-sm font-light text-gray-900 whitespace-nowrap">{{ number_format($product->display_price) }}đ</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
<style>[x-cloak]{display:none!important}</style>
@endsection
