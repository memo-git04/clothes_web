@extends('layouts.app')
@section('content')
<main class="pt-[120px]">
        <section class="mx-auto max-w-[1800px] px-6 lg:px-10 mb-24">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=1200&q=80" 
                         class="w-full h-full object-cover" alt="Hero Image">
                    <span class="absolute top-6 left-6 bg-black text-white text-[9px] px-3 py-1 uppercase tracking-widest">New Arrival</span>
                </div>
                <div class="mt-10 lg:mt-0 lg:pl-12">
                    <p class="text-[11px] uppercase tracking-[0.3em] text-gray-400 mb-4">Summer Collection 2026</p>
                    <h2 class="font-serif text-5xl lg:text-7xl font-light leading-tight mb-8">
                        The Oversized <br>Pea Blazer
                    </h2>
                    <p class="text-gray-500 max-w-md leading-relaxed mb-10 text-sm">
                        Khám phá sự kết hợp hoàn hảo giữa phong cách tối giản và chất liệu cao cấp. 
                        Thiết kế dành riêng cho những tín đồ thời trang hiện đại.
                    </p>
                    <a href="/shop" class="inline-block border-b border-black pb-2 text-[11px] uppercase tracking-[0.2em] hover:text-gray-400 hover:border-gray-400 transition">
                        Shop the Collection
                    </a>
                </div>
            </div>
        </section>
        <div class="w-full bg-[#f2f2f2] border-y border-gray-200 py-8 mb-16"> <div class="max-w-[1800px] mx-auto px-6 lg:px-10 text-center relative"> <div class="inline-block">
            <span class="text-[9px] uppercase tracking-[0.4em] text-gray-500 block mb-1">Curated Selection</span>
            <h2 class="font-serif text-3xl md:text-4xl font-normal tracking-wider text-black">Best Sellers</h2>
        </div>

        <section class="mx-auto max-w-[1800px] px-6 lg:px-10 pb-20">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-12">
                </div>
        </section>    
        
        <section class="mx-auto max-w-[1800px] px-6 lg:px-10 pb-20">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-12">
                <div class="group">
                    <div class="relative group overflow-hidden aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="Product">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                            <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <a href="{{ route('product.details', ['id' => 1]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                </svg>
                            </a>
                        </div>    
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-serif text-sm font-light">Silk Drape Dress</h3>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Ready-to-wear</p>
                    </div>
                    <p class="text-xs font-light">$450</p>
                </div>
            </div>

            <div class="group"> 
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 2]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div>     
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Tailored Wool Trousers</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Limited Edition</p>
                    </div>
                    <p class="text-xs font-light">$320</p>
                </div>
            </div>

            <div class="group">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 3]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div> 
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Summer Knit Top</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">New Arrival</p>
                    </div>
                    <p class="text-xs font-light">$180</p>
                </div>
            </div>

            <div class="group ">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 4]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div>     
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Classic Trench</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Essential</p>
                    </div>
                    <p class="text-xs font-light">$890</p>
                </div>
            </div>

            <div class="group">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 5]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div>     
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Linen Blouse</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Limited</p>
                    </div>
                    <p class="text-xs font-light">$210</p>
                </div>
            </div>

        </div>
</section>
 <section class="mx-auto max-w-[1800px] px-6 lg:px-10 pb-20">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-6 gap-y-12">
                <div class="group">
                    <div class="relative group overflow-hidden aspect-[3/4]">
                        <img src="https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                            <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <a href="{{ route('product.details', ['id' => 6]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                                </svg>
                            </a>
                        </div> 
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-serif text-sm font-light">Silk Drape Dress</h3>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Ready-to-wear</p>
                    </div>
                    <p class="text-xs font-light">$450</p>
                </div>
            </div>

            <div class="group"> 
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 7]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div> 
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Tailored Wool Trousers</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Limited Edition</p>
                    </div>
                    <p class="text-xs font-light">$320</p>
                </div>
            </div>

            <div class="group">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 8]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div> 
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Summer Knit Top</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">New Arrival</p>
                    </div>
                    <p class="text-xs font-light">$180</p>
                </div>
            </div>

            <div class="group">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 9]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div> 
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Classic Trench</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Essential</p>
                    </div>
                    <p class="text-xs font-light">$890</p>
                </div>
            </div>

            <div class="group">
                <div class="relative group overflow-hidden aspect-[3/4]">
                    <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?w=1200" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="">
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                        <a href="{{ route('product.details', ['id' => 10]) }}" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                        </a>
                    </div> 
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-serif text-sm font-light">Linen Blouse</h3>
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Limited</p>
                    </div>
                    <p class="text-xs font-light">$210</p>
                </div>
            </div>

        </div>
</section>
</main>
@endsection