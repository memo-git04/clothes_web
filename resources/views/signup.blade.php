<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Innove</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
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
        <div class="lg:w-1/2 flex items-center justify-center p-16">
            <div class="w-full max-w-md">
                <h2 class="text-4xl font-serif mb-10">Create Account</h2>
                
                <form action="{{ route('register.process') }}" method="POST">
                    @csrf
                    <input type="text" name="full_name" placeholder="Full Name" class="w-full border-b py-3 mb-4" required>
                    <input type="text" name="user_name" placeholder="Username" class="w-full border-b py-3 mb-4" required>
                    <input type="email" name="email" placeholder="Email Address" class="w-full border-b py-3 mb-4" required>
                    <input type="password" name="password" placeholder="Password" class="w-full border-b py-3 mb-4" required>
                    <input type="text" name="phone" placeholder="Phone Number" class="w-full border-b py-3 mb-4">
                    <select name="gender" class="w-full border-b py-3 mb-4">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <input type="date" name="date_of_birth" class="w-full border-b py-3 mb-4">
                    <input type="text" name="address" placeholder="Address" class="w-full border-b py-3 mb-4">
                    <button type="submit" class="w-full bg-black text-white py-4">Create Account</button>
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

                <p class="mt-8 text-center">
                    Already have an account? <a href="{{ route('login') }}" class="font-bold underline">Sign In</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>