@extends('layouts.app')
@section('content')
<div class="w-full bg-white text-black min-h-screen"
     x-data="{
        // Khởi tạo danh sách items từ dữ liệu PHP Controller truyền xuống
        items: {{ json_encode($wishlistItems) }},
        
        // Hàm xóa item khỏi danh sách yêu thích
        removeItem(id) {
            this.items = this.items.filter(item => item.id !== id);
            
            // Mẹo: Bạn có thể gọi thêm API Axios/Fetch ở đây để xóa trong Database/Session thực tế
            // fetch(`/api/wishlist/remove/${id}`, { method: 'DELETE' });
        }
     }">
    
    <main class="pt-40 pb-20">
        <div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-10">
            
            <nav class="mb-16">
                <div class="flex items-center gap-3 text-[11px] tracking-[0.2em] uppercase text-neutral-400">
                    <a href="/" class="hover:text-black transition-colors">Home</a>
                    <span>/</span>
                    <span class="text-black">Wishlist</span>
                </div>
            </nav>

            <template x-if="items.length > 0">
                <div>
                    <div class="mb-16 border-b border-neutral-100 pb-12">
                        <div class="text-center space-y-4">
                            <h1 class="font-serif text-5xl md:text-6xl tracking-tight text-black italic">
                                My Wishlist
                            </h1>
                            <p class="text-neutral-500 text-xs tracking-[0.15em] uppercase">
                                <span x-text="items.length"></span> 
                                <span x-text="items.length === 1 ? 'item' : 'items'"></span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-6 lg:gap-8">
                        <template x-for="item in items" :key="item.id">
                            <article 
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="flex flex-col group relative"
                            >
                                <button 
                                    @click="removeItem(item.id)"
                                    class="absolute top-4 right-4 z-10 p-2 bg-white/80 backdrop-blur-sm rounded-full text-neutral-400 hover:text-black transition-colors"
                                    aria-label="Remove item"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <div class="mb-6 overflow-hidden bg-neutral-50 relative aspect-[3/4]">
                                    <img 
                                        :src="item.image" 
                                        :alt="item.name"
                                        class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-105"
                                    />
                                    
                                    <div class="absolute inset-x-4 bottom-4 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                        <a :href="'/shop/' + item.slug" 
                                           class="w-full block text-center bg-black text-white text-[10px] tracking-[0.2em] uppercase py-3 hover:bg-neutral-800 transition-colors font-medium shadow-sm"
                                        >
                                            Select Options
                                        </a>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <p class="font-sans text-[10px] tracking-widest text-neutral-400 uppercase" x-text="item.category"></p>
                                    <h3 class="font-serif text-lg tracking-tight text-black">
                                        <a :href="'/shop/' + item.slug" x-text="item.name" class="hover:text-neutral-600 transition-colors"></a>
                                    </h3>
                                    <div class="flex items-center justify-between pt-1">
                                        <p class="font-serif text-sm text-neutral-900" x-text="'$' + item.price"></p>
                                        <span class="text-[9px] tracking-widest uppercase font-medium text-emerald-600" x-text="item.in_stock ? 'In Stock' : 'Low Stock'"></span>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>

                    <div class="flex justify-center mt-20 pt-12 border-t border-neutral-100">
                        <a href="/shop" class="text-xs tracking-[0.2em] uppercase text-black hover:text-neutral-400 transition-colors pb-1 border-b border-black">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </template>

            <template x-if="items.length === 0">
                <div class="text-center py-24 max-w-md mx-auto space-y-6" x-cloak>
                    <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mx-auto text-neutral-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h2 class="font-serif text-2xl text-black italic">Your wishlist is empty</h2>
                        <p class="text-neutral-500 text-sm leading-relaxed font-sans">
                            Save your favorite luxury pieces here to keep track of what you love.
                        </p>
                    </div>
                    <div class="pt-4">
                        <a href="/shop" class="inline-block bg-black text-white text-[10px] tracking-[0.2em] uppercase px-10 py-4 hover:bg-neutral-800 transition-colors font-medium">
                            Return To Shop
                        </a>
                    </div>
                </div>
            </template>

        </div>
    </main>
</div>

<style>
    .font-serif { font-family: 'Playfair Display', serif; }
    .font-sans { font-family: 'Inter', sans-serif; }
    [x-cloak] { display: none !important; }
</style>
@endsection