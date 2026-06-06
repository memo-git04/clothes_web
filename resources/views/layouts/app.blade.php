<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
        <nav class="hidden lg:flex gap-10 text-[13px] uppercase tracking-[0.2em]">
            <a href="/home" class="hover:text-gray-400 transition">Home</a>
            <div class="relative group">
                <a href="/shop" class="hover:text-gray-400 transition flex items-center gap-1">
                    Shop
                </a>
                <div class="absolute left-0 top-full pt-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl w-48 py-2">
                        <a href="/shop" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors border-b border-gray-50">
                        All Products
                        </a>
                        <a href="/shop_men" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors border-b border-gray-50">
                        Men
                        </a>
                        <a href="/shop_women" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                        Women
                        </a>
                    </div>
                </div>
            </div>
            <a href="/blog" class="hover:text-gray-400 transition">Blog</a>
            <a href="/contactus" class="hover:text-gray-400 transition">Contact Us</a>
        </nav>
            
    <div class="flex-1 flex items-center justify-end gap-6"> 
        <div class="relative hidden sm:block group">
        <input type="text" 
                placeholder="SEARCH" 
                class="bg-[#f9f9f9] border border-gray-100 py-2 px-4 pr-10 text-[9px] tracking-[0.2em] focus:outline-none focus:border-black w-48 transition-all duration-500 uppercase placeholder:text-gray-300"> 
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
        <a href="#" class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-[0.2em]">Wishlist</span>
        </a>

       <div x-data="{ cartCount: {{ count(session('cart', [])) }} }" 
            @cart-updated.window="cartCount = $event.detail">
            <a href="/cart" class="relative">
                   Giỏ hàng
                <span x-text="cartCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] rounded-full px-1"></span>
            </a>
        </div>  

@guest
    <a href="{{ url('/login') }}" class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        <span class="text-[10px] uppercase tracking-[0.2em] hidden xl:inline">Login</span>
    </a>
@endguest

@auth
    <div class="relative group" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center gap-2 hover:text-gray-400 transition-colors duration-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <span class="text-[10px] uppercase tracking-[0.2em] hidden xl:inline font-medium">
                {{ Auth::user()->full_name }}
            </span>
        </button>

        <div class="absolute right-0 top-full pt-4 opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
            <div class="bg-white border border-gray-100 shadow-xl w-48 py-2">
                <a href="{{ url('/profile') }}" class="block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors border-b border-gray-50 uppercase tracking-wider">
                    My Profile
                </a>
                
                @if(Auth::user()->role === 'admin') {{-- Nếu đồ án có phân quyền admin --}}
                <a href="{{ url('/admin') }}" class="block px-6 py-3 text-[11px] text-red-600 hover:bg-gray-50 transition-colors border-b border-gray-50 uppercase tracking-wider">
                    Admin Dashboard
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full text-left block px-6 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-black transition-colors uppercase tracking-wider">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endauth
        </div>
        </header>
        <main>
            @yield('content')
        </main>
        <footer class="border-t py-20 px-10">
        <div class="max-w-[1800px] mx-auto grid grid-cols-1 lg:grid-cols-4 gap-12">
            <div class="col-span-2">
                <h4 class="font-serif text-2xl tracking-widest mb-6">BKACAD</h4>
                <p class="text-gray-400 text-xs max-w-xs leading-loose">
                    Đồ án tốt nghiệp BKACAD - 2026. 
                    HoangNguyenThanhQuan-NguyenThiMai.
                </p>
            </div>
            <div>
                <h5 class="text-[10px] uppercase tracking-widest mb-6 font-semibold">Support</h5>
                <ul class="text-xs text-gray-500 space-y-4">
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Size Guide</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-[10px] uppercase tracking-widest mb-6 font-semibold">Social</h5>
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