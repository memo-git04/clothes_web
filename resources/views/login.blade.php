<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Innove Couture</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js (Xử lý Show/Hide Password và Checkbox) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:italic,wght@400;500&display=swap" rel="stylesheet">

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

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- LEFT SECTION: BRAND/VISUAL -->
        <div class="lg:w-1/2 bg-[#1a2744] relative flex flex-col justify-between p-8 lg:p-16 min-h-[40vh] lg:min-h-screen overflow-hidden">
            <!-- Logo -->
            <div class="z-10">
                <a href="/" class="inline-block">
                    <span class="text-white text-xl tracking-[0.3em] font-sans uppercase">
                        BKACAD
                    </span>
                </a>
            </div>

            <!-- Center Content -->
            <div class="flex-1 flex flex-col justify-center items-center text-center py-12 lg:py-0 z-10">
                <h1 class="font-serif text-4xl lg:text-6xl text-white font-light mb-4 tracking-tight">
                    HNTQxNTM
                </h1>
                <p class="text-white/70 font-sans text-sm lg:text-base max-w-xs tracking-wide leading-relaxed">
                    Sign in to access your account and continue your fashion journey with us.
                </p>
            </div>

            <!-- Abstract Geometric Shape (SVG) -->
            <div class="absolute bottom-0 left-0 right-0 h-48 lg:h-64 opacity-10 pointer-events-none">
                <svg viewBox="0 0 400 200" class="w-full h-full" preserveAspectRatio="xMidYMax slice">
                    <circle cx="50" cy="180" r="120" fill="white" />
                    <circle cx="350" cy="200" r="80" fill="white" />
                    <rect x="150" y="100" width="100" height="100" fill="white" transform="rotate(45 200 150)" />
                </svg>
            </div>

            <!-- Decorative Lines -->
            <div class="absolute top-1/4 right-8 lg:right-16 w-px h-24 bg-white/20"></div>
            <div class="absolute bottom-1/4 left-8 lg:left-16 w-16 h-px bg-white/20"></div>
        </div>

        <!-- RIGHT SECTION: FORM -->
        <div class="lg:w-1/2 bg-white flex items-center justify-center p-8 lg:p-16" 
             x-data="{ showPassword: false, rememberMe: false }">
            
           <div class="w-full max-w-md">
                <div class="mb-10">
                    <h2 class="font-serif text-3xl lg:text-4xl text-black font-light mb-2">Sign In</h2>
                    <p class="text-gray-500 font-sans text-sm">Enter your credentials to access your account</p>
                </div>

                @if($errors->has('customerError'))
                    <div class="mb-6 p-4 bg-red-50 border-l border-red-500 text-xs uppercase tracking-widest text-red-600 font-sans font-medium">
                        {{ $errors->first('customerError') }}
                    </div>
                @endif

                <form action="{{ route('customer.loginProcess') }}" method="POST" class="space-y-6">
                    @csrf <div>
                        <label for="email" class="block text-[10px] font-sans uppercase tracking-[0.15em] text-gray-400 mb-2">
                            Email Address
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}" required
                            class="w-full px-0 py-3 bg-transparent border-0 border-b border-gray-200 text-black placeholder:text-gray-300 focus:outline-none focus:border-black transition-colors duration-300 font-sans"
                            placeholder="your@email.com"
                        >
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1 font-sans">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-[10px] font-sans uppercase tracking-[0.15em] text-gray-400 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                class="w-full px-0 py-3 pr-10 bg-transparent border-0 border-b border-gray-200 text-black placeholder:text-gray-300 focus:outline-none focus:border-black transition-colors duration-300 font-sans"
                                placeholder="Enter your password"
                            >
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-0 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors"
                            >
                                <template x-if="!showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </template>
                                <template x-if="showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                </template>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-[11px] mt-1 font-sans">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="remember" class="sr-only" x-model="rememberMe">
                                <div class="w-4 h-4 border transition-colors duration-200" 
                                     :class="rememberMe ? 'bg-black border-black' : 'border-gray-200 group-hover:border-gray-400'">
                                    <template x-if="rememberMe">
                                        <svg class="w-4 h-4 text-white" viewBox="0 0 16 16" fill="none">
                                            <path d="M3.5 8L6.5 11L12.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </template>
                                </div>
                            </div>
                            <span class="text-xs font-sans text-gray-500 uppercase tracking-widest">Remember me</span>
                        </label>
                        <a href="#" class="text-xs font-sans text-gray-500 uppercase tracking-widest hover:text-black transition-colors fashion-link">
                            Forgot Password?
                        </a>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-black text-white py-4 font-sans text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 transition-colors duration-300"
                        >
                            Sign In
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-gray-100"></div>
                    <span class="text-[10px] font-sans uppercase tracking-[0.15em] text-gray-400">
                        Or continue with
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                <!-- Social Login -->
                <div class="flex justify-center gap-4">
                    <!-- Google -->
                    <button class="w-12 h-12 border border-gray-100 flex items-center justify-center hover:border-black transition-all duration-300">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </button>
                    <!-- Facebook -->
                    <button class="w-12 h-12 border border-gray-100 flex items-center justify-center hover:border-black transition-all duration-300">
                        <svg class="w-4 h-4 text-[#1877F2]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                </div>

                <!-- Sign Up Link -->
                <p class="text-center mt-10 text-[10px] uppercase tracking-widest text-gray-400">
                    Don't have an account? 
                    <a href="#" class="text-black hover:text-gray-600 transition-colors fashion-link ml-1">Sign Up</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>