@extends('layouts.app')
@section('content')
<div class="w-full bg-white text-black" 
     x-data="{ 
        displayedPosts: 6, 
        totalPosts: {{ count($blogPosts) }},
        email: '',
        subscribed: false,
        handleSubscribe() {
            if(this.email) {
                this.subscribed = true;
                this.email = '';
                setTimeout(() => this.subscribed = false, 3000);
            }
        }
     }">
    
    <main class="w-full">
        <section class="w-full border-b border-neutral-200">
            <div class="mx-auto max-w-7xl px-6 py-24 md:py-32 lg:py-40">
                <div class="text-center">
                    <p class="font-sans text-[10px] tracking-[0.3em] font-medium text-neutral-600 mb-6 uppercase">
                        OUR BLOGS
                    </p>
                    <h1 class="font-serif text-5xl md:text-7xl font-light mb-8 tracking-tight italic">
                        HNTQxNTM Stories
                    </h1>
                    <p class="font-sans text-base md:text-lg tracking-wide text-neutral-500 max-w-2xl mx-auto leading-relaxed">
                        Discover the narratives, insights, and visions that shape our collections and cultural conversations.
                    </p>
                </div>
            </div>
        </section>

        <section class="w-full border-b border-neutral-200">
            <div class="mx-auto max-w-7xl px-6 py-20 md:py-28">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16">
                    @foreach($blogPosts as $index => $post)
                    <article 
                        x-show="{{ $index }} < displayedPosts" 
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        class="flex flex-col group"
                    >
                        <div class="mb-8 overflow-hidden bg-neutral-100">
                            <div class="relative aspect-[2/3] overflow-hidden">
                                <img
                                    src="{{ $post['image'] }}"
                                    alt="{{ $post['title'] }}"
                                    class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-105"
                                />
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <p class="font-sans text-[10px] tracking-[0.25em] font-medium text-neutral-600 mb-4 uppercase">
                                {{ $post['category'] }}
                            </p>

                            <h2 class="font-serif text-2xl md:text-3xl font-light mb-4 tracking-tight leading-tight hover:text-neutral-600 transition-colors">
                                <a href="/press/{{ $post['slug'] }}">{{ $post['title'] }}</a>
                            </h2>

                            <p class="font-sans text-sm md:text-base text-neutral-700 mb-6 leading-relaxed flex-1">
                                {{ Str::limit($post['excerpt'], 120) }}
                            </p>

                            <div class="flex items-center justify-between pt-6 border-t border-neutral-100">
                                <p class="font-sans text-[10px] tracking-[0.15em] text-neutral-400 uppercase">
                                    {{ $post['date'] }}
                                </p>
                                <a
                                    href="/press/{{ $post['slug'] }}"
                                    class="font-sans text-[10px] tracking-[0.2em] text-black inline-flex items-center gap-2 uppercase group/link"
                                >
                                    Read 
                                    <svg class="w-3 h-3 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                
                    @endforeach
                </div>

                <div class="flex justify-center mt-16 md:mt-20" x-show="displayedPosts < totalPosts">
                    <button
                        @click="displayedPosts += 3"
                        class="font-sans text-xs tracking-[0.2em] font-medium text-black border-b border-black pb-2 transition-all duration-300 hover:pb-4 uppercase"
                    >
                        Load More Articles
                    </button>
                </div>
            </div>
        </section>
        
    </main>
</div>

<style>
    /* Custom font fallback if not in layouts.app */
    .font-serif { font-family: 'Playfair Display', serif; }
    .font-sans { font-family: 'Inter', sans-serif; }
    
    [x-cloak] { display: none !important; }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.5s ease-out forwards; }
</style>
@endsection