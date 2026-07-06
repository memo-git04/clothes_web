@extends('layouts.app')

@section('content')

    <div class="w-full bg-white text-black min-h-screen"
         x-data="{
        submitted: false,
        name: '',
        email: '',
        phone: '',
        inquiryType: 'General Inquiry',
        message: '',

        handleSubmit() {
            this.submitted = true;
            setTimeout(() => {
                this.submitted = false;
                this.name = '';
                this.email = '';
                this.phone = '';
                this.inquiryType = 'General Inquiry';
                this.message = '';
            }, 3000);
        }
     }">

        <main class="min-h-screen bg-white pb-10 sm:pt-5">
            <div class="mx-auto max-w-[1300px] px-4 sm:px-6 lg:px-12">

                <div class="mb-16 sm:mb-24">
                    <div class="text-[10px] tracking-[0.2em] uppercase text-neutral-400">
                        <a href="/" class="hover:text-black transition-colors">Trang chủ</a>
                        <span class="mx-2 text-neutral-300">/</span>
                        <span class="text-black">Liên hệ</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">

                    <!-- Phần Thông tin liên hệ -->
                    <div>
                        <div class="mb-20">
                            <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl font-light text-black mb-4 tracking-tight italic">
                                Liên hệ<br />với chúng tôi
                            </h1>
                            <p class="text-neutral-500 text-sm tracking-wide leading-relaxed max-w-md">
                                Chúng tôi rất trân trọng mọi câu hỏi từ bạn. Hãy liên hệ với chúng tôi qua thông tin bên dưới hoặc gửi tin nhắn qua form.
                            </p>
                        </div>

                        <div class="space-y-16">

                            <div>
                                <h3 class="text-[11px] tracking-[0.2em] uppercase text-black font-medium mb-6">
                                    Chăm sóc khách hàng
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Hỏi đáp chung
                                        </p>
                                        <a href="mailto:hello@innove.com" class="text-black text-sm pb-1 border-b border-transparent hover:border-black transition-colors">
                                            hello@innove.com
                                        </a>
                                    </div>
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Điện thoại
                                        </p>
                                        <a href="tel:+1-800-INNOVE-1" class="text-black text-sm pb-1 border-b border-transparent hover:border-black transition-colors">
                                            +1 (800) INNOVE-1
                                        </a>
                                    </div>
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Giờ làm việc
                                        </p>
                                        <p class="text-sm text-black leading-relaxed">
                                            Thứ Hai – Thứ Sáu: 9:00 AM – 7:00 PM (EST)<br />
                                            Thứ Bảy: 10:00 AM – 5:00 PM (EST)<br />
                                            Chủ Nhật: Nghỉ
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-[11px] tracking-[0.2em] uppercase text-black font-medium mb-6">
                                    Báo chí & Truyền thông
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Email
                                        </p>
                                        <a href="mailto:press@innove.com" class="text-black text-sm pb-1 border-b border-transparent hover:border-black transition-colors">
                                            press@innove.com
                                        </a>
                                    </div>
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Tài liệu truyền thông
                                        </p>
                                        <a href="#" class="text-black text-sm pb-1 border-b border-transparent hover:border-black transition-colors">
                                            Tải Press Kit
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-[11px] tracking-[0.2em] uppercase text-black font-medium mb-6">
                                    Trụ sở chính
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            New York
                                        </p>
                                        <p class="text-sm text-black leading-relaxed">
                                            INNOVE, Inc.<br />
                                            450 Park Avenue<br />
                                            New York, NY 10022<br />
                                            United States
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] tracking-[0.15em] uppercase text-neutral-400 mb-2">
                                            Milan
                                        </p>
                                        <p class="text-sm text-black leading-relaxed">
                                            INNOVE Design Studio<br />
                                            Via Monte di Pietà 23<br />
                                            20121 Milan<br />
                                            Italy
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Form liên hệ -->
                    <div>
                        <div class="mb-16">
                            <h2 class="font-serif text-3xl sm:text-4xl font-light text-black mb-4 tracking-tight">
                                Gửi tin nhắn cho chúng tôi
                            </h2>
                            <p class="text-sm text-neutral-500 tracking-wide">
                                Chúng tôi sẽ phản hồi trong vòng 24 giờ trong ngày làm việc.
                            </p>
                        </div>

                        <div x-show="submitted"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mb-8 p-6 border-l-2 border-black bg-neutral-50"
                             x-cloak>
                            <p class="text-sm text-black tracking-wide">
                                Cảm ơn bạn đã gửi tin nhắn. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="mb-8 p-6 border-l-2 border-emerald-600 bg-emerald-50">
                                <p class="text-sm text-emerald-800 tracking-wide">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-8 p-6 border-l-2 border-red-600 bg-red-50">
                                <ul class="text-sm text-red-700 list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <form x-ref="contactForm" action="{{ route('contact.store') }}" method="POST" class="space-y-10">
                            @csrf

                            <div>
                                <label for="name" class="block text-[10px] tracking-[0.15em] uppercase text-black mb-4">
                                    Họ và tên
                                </label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    x-model="name"
                                    placeholder="HỌ VÀ TÊN CỦA BẠN"
                                    required
                                    class="w-full py-3 px-0 bg-transparent border-b border-neutral-200 text-sm focus:outline-none focus:border-black transition-colors duration-300 placeholder:text-neutral-300 placeholder:text-[11px] placeholder:tracking-[0.1em] placeholder:uppercase"
                                />
                            </div>

                            <div>
                                <label for="email" class="block text-[10px] tracking-[0.15em] uppercase text-black mb-4">
                                    Địa chỉ Email
                                </label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    x-model="email"
                                    placeholder="YOUR@EMAIL.COM"
                                    required
                                    class="w-full py-3 px-0 bg-transparent border-b border-neutral-200 text-sm focus:outline-none focus:border-black transition-colors duration-300 placeholder:text-neutral-300 placeholder:text-[11px] placeholder:tracking-[0.1em] placeholder:uppercase"
                                />
                            </div>
                            <div>
                                <label for="phone" class="block text-[10px] tracking-[0.15em] uppercase text-black mb-4">
                                    Số điện thoại
                                </label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    x-model="phone"
                                    placeholder="+84 123 456 789"
                                    required
                                    class="w-full py-3 px-0 bg-transparent border-b border-neutral-200 text-sm focus:outline-none focus:border-black transition-colors duration-300 placeholder:text-neutral-300 placeholder:text-[11px] placeholder:tracking-[0.1em] placeholder:uppercase"
                                />
                            </div>

                            <div>
                                <label for="inquiryType" class="block text-[10px] tracking-[0.15em] uppercase text-black mb-4">
                                    Loại yêu cầu
                                </label>
                                <div class="relative">
                                    <select
                                        id="inquiryType"
                                        name="subject"
                                        x-model="inquiryType"
                                        class="w-full py-3 px-0 bg-transparent border-b border-neutral-200 text-sm focus:outline-none focus:border-black transition-colors duration-300 appearance-none cursor-pointer rounded-none"
                                    >
                                        <option value="General Inquiry">Hỏi đáp chung</option>
                                        <option value="Customer Support">Hỗ trợ khách hàng</option>
                                        <option value="Press & Media">Báo chí & Truyền thông</option>
                                        <option value="Collaboration">Hợp tác</option>
                                        <option value="Other">Khác</option>
                                    </select>
                                    <span class="absolute right-0 top-1/2 -translate-y-1/2 pointer-events-none text-neutral-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                                </span>
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-[10px] tracking-[0.15em] uppercase text-black mb-4">
                                    Nội dung tin nhắn
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    x-model="message"
                                    placeholder="VIẾT TIN NHẮN CỦA BẠN TẠI ĐÂY..."
                                    required
                                    rows="6"
                                    class="w-full py-3 px-0 bg-transparent border-b border-neutral-200 text-sm focus:outline-none focus:border-black transition-colors duration-300 placeholder:text-neutral-300 placeholder:text-[11px] placeholder:tracking-[0.1em] placeholder:uppercase resize-none rounded-none"
                                ></textarea>
                            </div>

                            <div class="pt-6">
                                <button
                                    type="submit"
                                    class="w-full py-4 px-6 bg-black text-white text-sm tracking-[0.15em] uppercase font-medium transition-all duration-300 hover:bg-neutral-800 flex items-center justify-center gap-3"
                                >
                                    <span>Gửi tin nhắn</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>

                            <p class="text-xs text-neutral-400 text-center pt-4 tracking-wide">
                                Chúng tôi tôn trọng quyền riêng tư của bạn. Thông tin sẽ chỉ được sử dụng để phản hồi yêu cầu.
                            </p>

                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <style>
        .font-serif { font-family: 'Inter', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

@endsection
