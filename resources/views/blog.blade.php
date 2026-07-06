@extends('layouts.app')

@section('content')

    <div class="w-full bg-white text-black">
        <main class="w-full">
            <!-- Header -->
            <section class="w-full border-b border-neutral-200">
                <div class="mx-auto max-w-7xl px-6 py-2 md:py-12">
                    <div class="text-center">
                        <p class="font-sans text-[10px] tracking-[0.3em] font-medium text-neutral-600 mb-6 uppercase">
                            <strong><h2>BLOG THỜI TRANG</h2> </strong>
                        </p>
                        <p class="font-sans text-base md:text-lg tracking-wide text-neutral-500 max-w-2xl mx-auto leading-relaxed">
                            Khám phá những câu chuyện, góc nhìn và cảm hứng đằng sau từng bộ sưu tập thời trang của chúng tôi.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Danh sách bài viết -->
            <section class="w-full">
                <div class="mx-auto max-w-7xl px-6 py-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">

                        <!-- Bài 1 -->
                        <article class="flex flex-col group">
                            <div class="mb-8 overflow-hidden bg-neutral-100">
                                <div class="relative aspect-[16/11] overflow-hidden">
                                    <img src="{{ asset('admin/img/blog3.jpg') }}"
                                         alt="Fashion Story"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <p class="font-sans text-[10px] tracking-[0.25em] font-medium text-neutral-600 mb-4 uppercase">TREND</p>
                                <h2 class="font-serif text-2xl md:text-3xl font-light mb-4 tracking-tight leading-tight group-hover:text-neutral-600 transition-colors">
                                    <a href="#">Những Xu Hướng Thời Trang Nam Nổi Bật Mùa Thu 2026</a>
                                </h2>
                                <p class="font-sans text-sm md:text-base text-neutral-700 mb-6 leading-relaxed flex-1">
                                    Khám phá những item không thể thiếu trong tủ đồ nam giới mùa thu này...
                                </p>
                                <div class="flex items-center justify-between pt-6 border-t border-neutral-100">
                                    <p class="font-sans text-[10px] tracking-[0.15em] text-neutral-400 uppercase">05 THÁNG 7, 2026</p>
                                    <a href="#" class="font-sans text-[10px] tracking-[0.2em] text-black inline-flex items-center gap-2 uppercase hover:gap-3 transition-all">
                                        Đọc tiếp
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Bài 2 -->
                        <article class="flex flex-col group">
                            <div class="mb-8 overflow-hidden bg-neutral-100">
                                <div class="relative aspect-[16/11] overflow-hidden">
                                    <img src="{{ asset('admin/img/blog.jpg') }}"
                                         alt="Street Style"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <p class="font-sans text-[10px] tracking-[0.25em] font-medium text-neutral-600 mb-4 uppercase">STREET STYLE</p>
                                <h2 class="font-serif text-2xl md:text-3xl font-light mb-4 tracking-tight leading-tight group-hover:text-neutral-600 transition-colors">
                                    <a href="#">Phong Cách Streetwear Đang Lên Ngôi Tại Việt Nam</a>
                                </h2>
                                <p class="font-sans text-sm md:text-base text-neutral-700 mb-6 leading-relaxed flex-1">
                                    Từ Sài Gòn đến Hà Nội, giới trẻ đang biến streetwear thành một phần không thể thiếu...
                                </p>
                                <div class="flex items-center justify-between pt-6 border-t border-neutral-100">
                                    <p class="font-sans text-[10px] tracking-[0.15em] text-neutral-400 uppercase">03 THÁNG 7, 2026</p>
                                    <a href="#" class="font-sans text-[10px] tracking-[0.2em] text-black inline-flex items-center gap-2 uppercase hover:gap-3 transition-all">
                                        Đọc tiếp
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <!-- Bài 3 -->
                        <article class="flex flex-col group">
                            <div class="mb-8 overflow-hidden bg-neutral-100">
                                <div class="relative aspect-[16/11] overflow-hidden">
                                    <img src="{{asset('admin/img/blog2.jpg') }}"
                                         alt="Sustainable Fashion"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col">
                                <p class="font-sans text-[10px] tracking-[0.25em] font-medium text-neutral-600 mb-4 uppercase">BỀN VỮNG</p>
                                <h2 class="font-serif text-2xl md:text-3xl font-light mb-4 tracking-tight leading-tight group-hover:text-neutral-600 transition-colors">
                                    <a href="#">Thời Trang Bền Vững – Xu Hướng Tương Lai Của Ngành May Mặc</a>
                                </h2>
                                <p class="font-sans text-sm md:text-base text-neutral-700 mb-6 leading-relaxed flex-1">
                                    Làm thế nào để vừa đẹp vừa thân thiện với môi trường?...
                                </p>
                                <div class="flex items-center justify-between pt-6 border-t border-neutral-100">
                                    <p class="font-sans text-[10px] tracking-[0.15em] text-neutral-400 uppercase">01 THÁNG 7, 2026</p>
                                    <a href="#" class="font-sans text-[10px] tracking-[0.2em] text-black inline-flex items-center gap-2 uppercase hover:gap-3 transition-all">
                                        Đọc tiếp
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        </article>

                    </div>

                    <!-- Load More -->
                    <div class="flex justify-center mt-20">
                        <button onclick="alert('Chức năng Load More sẽ được cập nhật sau!')"
                                class="font-sans text-xs tracking-[0.2em] font-medium text-black border-b border-black pb-2 hover:pb-4 transition-all uppercase">
                            Xem thêm bài viết
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <style>
        .font-serif { font-family: 'Inter', serif; }
        .font-sans  { font-family: 'Inter', system-ui, sans-serif; }
    </style>

@endsection
