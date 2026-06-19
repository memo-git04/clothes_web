<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Innove Couture</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }

        .fashion-link {
            position: relative;
            text-decoration: none;
        }
        .fashion-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: currentColor;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        .fashion-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>
<body class="bg-white text-[#1a1a1a] overflow-x-hidden">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl mx-auto flex flex-col lg:flex-row shadow-2xl rounded-3xl overflow-hidden bg-white">

        <!-- LEFT SECTION -->
        <div class="lg:w-1/2 bg-[#1a2744] relative flex flex-col justify-between p-8 lg:p-16 min-h-[420px] lg:min-h-screen">
            <div>
                <span class="text-white text-xl tracking-[0.3em] font-sans uppercase">INNOVE COUTURE</span>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center text-center py-8 lg:py-0">
                <h1 class="font-serif text-5xl lg:text-6xl text-white font-light tracking-tight mb-4">
                    THỜI TRANG

                    HIỆN ĐẠI
                </h1>
                <p class="text-white/80 text-base max-w-xs leading-relaxed">
                    Đăng nhập để truy cập tài khoản của bạn và tiếp tục hành trình thời trang cùng chúng tôi!
                </p>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-64 opacity-10 pointer-events-none">
                <svg viewBox="0 0 400 200" class="w-full h-full" preserveAspectRatio="xMidYMax slice">
                    <circle cx="50" cy="180" r="120" fill="white"/>
                    <circle cx="350" cy="200" r="80" fill="white"/>
                    <rect x="150" y="100" width="100" height="100" fill="white" transform="rotate(45 200 150)"/>
                </svg>
            </div>
        </div>

        <!-- RIGHT SECTION - FORM -->
        <div class="lg:w-1/2 bg-white flex items-center justify-center p-8 lg:p-12"
             x-data="{ showPassword: false, rememberMe: false }">

            <div class="w-full max-w-md space-y-8">
                <div>
                    <h2 class="font-serif text-4xl text-black font-light">ĐĂNG NHẬP</h2>
                    <p class="text-gray-600 mt-2">Nhập thông tin đăng nhập của bạn để truy cập vào tài khoản.</p>
                </div>

                <form action="{{route('customerLogin')}}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Email / Phone / Username -->
                    <div>
                        <input type="text" name="email" required
                               class="w-full px-4 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-black transition-all text-base placeholder:text-gray-400"
                               placeholder="Email hoặc SĐT hoặc Tên đăng nhập">
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            name="password" required
                            class="w-full px-4 py-4 border border-gray-300 rounded-2xl focus:outline-none focus:border-black transition-all text-base pr-12 placeholder:text-gray-400"
                            placeholder="Mật khẩu">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xl transition-colors">
                            <template x-if="!showPassword">👁️</template>
                            <template x-if="showPassword">🙈</template>
                        </button>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="rememberMe" class="w-4 h-4 accent-black">
                            <span class="text-gray-600">Ghi nhớ tôi</span>
                        </label>
                        <a href="#" class="text-gray-600 hover:text-black transition-colors">Quên mật khẩu?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-medium tracking-wider text-sm transition-colors">
                        ĐĂNG NHẬP
                    </button>
                </form>

                <!-- Divider -->
                <div class="flex items-center gap-4">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400 uppercase tracking-widest">hoặc</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <!-- Social Login -->
                <div class="flex justify-center gap-4">
                    <button class="w-12 h-12 border border-gray-300 rounded-2xl hover:border-black transition-colors flex items-center justify-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" class="w-5 h-5" alt="Google">
                    </button>
                    <button class="w-12 h-12 border border-gray-300 rounded-2xl hover:border-black transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#1877F2]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                </div>

                <p class="text-center text-gray-500 text-sm">
                    Chưa có tài khoản?
                    <a href="{{route('register')}}" class="text-black font-medium hover:underline">Đăng ký</a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
