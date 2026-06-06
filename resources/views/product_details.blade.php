@extends('layouts.app')

@section('content')
<main class="max-w-[1440px] mx-auto px-4 md:px-8 lg:px-12 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-[10px] tracking-[0.2em] uppercase text-gray-400 mb-8">
        <a href="/" class="hover:text-black">Home</a>
        <span>/</span>
        <a href="/shop" class="hover:text-black">Shop</a>
        <span>/</span>
        <a href="#" class="hover:text-black">Jackets</a>
        <span>/</span>
        <span class="text-black italic">Oversized Pea Blazer</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
        <!-- Bên trái: Ảnh sản phẩm (Chiếm 7 cột) -->
        <div class="lg:col-span-7">
            <div class="aspect-[4/5] bg-[#f5f5f5] overflow-hidden group relative">
                <!-- Thay ảnh placeholder bằng ảnh thật từ DB của ông -->
                <img src="{{ asset('https://images.unsplash.com/photo-1548624313-0396c75e4b1a?w=1200') }}" alt="Product Image" class="w-full h-full object-cover">
                
                <!-- Badge (nếu có) -->
                <div class="absolute top-6 left-6">
                    <span class="bg-black text-white text-[10px] tracking-widest uppercase px-3 py-1">New Collection</span>
                </div>
            </div>
        </div>

        <!-- Bên phải: Thông tin sản phẩm (Chiếm 5 cột) -->
        <div class="lg:col-span-5 flex flex-col">
            <span class="text-[11px] tracking-[0.2em] uppercase text-gray-400 mb-2">Jackets</span>
            <h1 class="text-4xl font-light italic tracking-tight mb-4 text-[#1a1a1a]">Oversized Pea Blazer in Black</h1>
            
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
                <span class="text-2xl text-[#d97771] font-light">$245</span>
                <span class="text-lg text-gray-300 line-through font-light">$295</span>
                <span class="px-2 py-0.5 bg-[#fdf2f2] text-[#d97771] text-[10px] tracking-wider uppercase">Save $50</span>
            </div>

            <p class="text-sm text-gray-600 leading-relaxed mb-10 font-light">
                An oversized pea blazer crafted from premium wool blend fabric. Features double-breasted front with statement buttons, notched lapels, and a relaxed fit that layers beautifully over knitwear and tailored pieces.
            </p>

            <!-- Chọn màu (Color Selection) -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-medium uppercase tracking-[0.15em]">Color: <span class="font-light text-gray-500" x-text="selectedColor"></span></span>
                </div>
                <div class="flex gap-3">
                    <button @click="selectedColor = 'Black'" :class="selectedColor === 'Black' ? 'ring-1 ring-black ring-offset-2' : ''" class="w-8 h-8 bg-black border border-black/10 transition-all"></button>
                    <button @click="selectedColor = 'Navy'" :class="selectedColor === 'Navy' ? 'ring-1 ring-black ring-offset-2' : ''" class="w-8 h-8 bg-[#1a1c2c] border border-black/10 transition-all"></button>
                    <button @click="selectedColor = 'Tan'" :class="selectedColor === 'Tan' ? 'ring-1 ring-black ring-offset-2' : ''" class="w-8 h-8 bg-[#c2a679] border border-black/10 transition-all"></button>
                </div>
            </div>

            <!-- Chọn Size -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[11px] font-medium uppercase tracking-[0.15em]">Size: <span class="font-light text-gray-400" x-text="selectedSize || 'Select a size'"></span></span>
                    <button  class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-200 hover:text-black transition">Size Guide</button>
                </div>
                <div class="grid grid-cols-5 gap-2">
                    @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
                        <button @click="selectedSize = '{{ $size }}'"
                                :class="selectedSize === '{{ $size }}' ? 'bg-black text-white' : 'bg-white text-black hover:border-black'"
                                class="h-12 border border-gray-200 text-[11px] transition-all duration-300">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Số lượng & Nút mua -->>
            <div class="flex flex-col gap-4">
                <span class="text-[11px] font-medium uppercase tracking-[0.15em]">Quantity</span>
                <div class="flex gap-4">
                    
                    <div class="relative w-24">
                        <select x-model="quantity" class="w-full h-14 border border-gray-200 pl-4 pr-8 appearance-none text-sm focus:outline-none focus:border-black bg-white">
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="button" 
                        @click="
                            fetch('{{ route('cart.add') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ product_id: 1, size: selectedSize, quantity: quantity })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if(data.success) {
                                    // Bắn sự kiện để menu tự cập nhật số lượng
                                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.newCount }));
                                    alert('Đã thêm vào giỏ hàng!');
                               }
                            })
                        "
                        class="bg-black text-white px-8 py-4 uppercase">
                        Add to Cart
                    </button>
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
            <a href="/shop" class="text-[10px] tracking-[0.2em] uppercase text-gray-400 hover:text-black transition-colors border-b border-gray-200">View All</a>
        </div>
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
                        <a href="/product_details/1" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
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
                        <a href="/product_details/2" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
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
                        <a href="/product_details/3" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
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
                        <a href="/product_details/4" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
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
                        <a href="/product_details/5" class="w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-black hover:text-white transition-colors">
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