<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INNOVE - Thời Trang Nam Nữ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
    </style>
</head>
<body>

<header class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
    <div class="max-w-[1800px] mx-auto px-6 lg:px-10 py-6 flex justify-between items-center">
        <div class="flex-1">
            <h1 class="font-serif text-3xl tracking-[0.4em] font-light pl-10">INNOVE</h1>
        </div>

        <nav class="hidden lg:flex gap-10 text-[13px] uppercase tracking-[0.2em]" style="margin-right: 150px">
            <a href="{{route('home')}}" class="hover:text-gray-400 transition">Trang chủ</a>
            <div class="relative group">
                <a href="{{ route('shop') }}" class="hover:text-gray-400 transition flex items-center gap-1">
                    Cửa hàng
                </a>
                <div class="absolute left-0 top-full pt-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl w-48 py-2">
                        <a href="{{ route('shop') }}" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors border-b border-gray-50">
                            Tất cả sản phẩm
                        </a>
                        <a href="{{ route('shop.men') }}" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors border-b border-gray-50">
                            Thời trang nam
                        </a>
                        <a href="{{ route('shop.women') }}" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                            Thời trang nữ
                        </a>
                    </div>
                </div>
            </div>
            <a href="{{route('blog')}}" class="hover:text-gray-400 transition">Blog</a>
            <a href="{{ route('contact') }}" class="hover:text-gray-400 transition">Liên hệ</a>
        </nav>

        <div class="flex-1 flex items-center justify-end gap-6">
            <!-- Search -->
            <form action="{{ route('search') }}" method="GET" class="relative hidden sm:block group">
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="SEARCH"
                       class="bg-[#f9f9f9] border border-gray-100 py-2 px-4 pr-10 text-[9px] tracking-[0.2em] focus:outline-none focus:border-black w-48 transition-all duration-500 uppercase placeholder:text-gray-300">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-black transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <!-- Wishlist -->
            <a href="{{ route('wishlist') }}" class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-[10px] uppercase tracking-[0.2em]">({{$wishlistCount ?? 0 }})</span>
            </a>

            <!-- Cart -->
            <a href="/cart" class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <span class="text-[10px] uppercase tracking-[0.2em]">
                       ({{ collect(session('cart', []))->count() }})
                    </span>
            </a>

            <!-- Account Dropdown - FIXED -->
            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                <button @click="open = !open"
                        class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span class="text-[10px] uppercase tracking-[0.2em] hidden xl:inline">
                            @if(Auth::check())
                            {{ Auth::user()->user_name ?? Auth::user()->full_name ?? 'Tài khoản' }}
                        @else
                            Tài khoản
                        @endif
                        </span>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                     x-transition
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100">

                @if(Auth::check())
                    <!-- Đã đăng nhập -->
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->full_name ?? Auth::user()->user_name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <a href="{{route('profile')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Thông tin tài khoản
                            </a>
                            <a href="{{route('orderHistory')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Lịch sử đơn hàng
                            </a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                Đăng xuất
                            </a>
                        </div>
                @else
                    <!-- Chưa đăng nhập -->
                        <div class="py-1">
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-t border-gray-100">
                                Đăng ký
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</header>

{{-- BODY CONTENT --}}
<main class="pt-24">
    @if(session('success') || session('error'))
        <div class="fixed top-24 right-6 z-[100]" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            @if(session('success'))
                <div class="mb-2 px-5 py-3 bg-emerald-600 text-white text-sm rounded shadow-lg max-w-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-2 px-5 py-3 bg-red-600 text-white text-sm rounded shadow-lg max-w-sm">{{ session('error') }}</div>
            @endif
        </div>
    @endif
    @yield('content')
</main>

<footer class="border-t py-20 pt-5 px-10">
    <div class="max-w-[1800px] mx-auto grid grid-cols-1 lg:grid-cols-4 gap-12">
        <div class="col-span-2">
            <h4 class="font-serif text-2xl tracking-widest mb-6">INNOVE COUTURE</h4>
            <p class="text-gray-400 text-xs max-w-xs leading-loose">
                THỜI TRANG - HIỆN ĐẠI
            </p>
        </div>
        <div>
            <h5 class="text-[10px] uppercase tracking-widest mb-6 font-semibold">HỖ TRỢ</h5>
            <ul class="text-xs text-gray-500 space-y-4">
                <li><a href="#">Giao hàng</a></li>
                <li><a href="#">Đổi trả</a></li>
                <li><a href="#">Hướng dẫn chọn size</a></li>
            </ul>
        </div>
        <div>
            <h5 class="text-[10px] uppercase tracking-widest mb-6 font-semibold">MẠNG XÃ HỘI</h5>
            <ul class="text-xs text-gray-500 space-y-4">
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Pinterest</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>
