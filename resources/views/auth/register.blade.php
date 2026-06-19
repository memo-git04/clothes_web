<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng Ký | Innove Couture</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>

<body class="bg-white text-[#1a1a1a] overflow-x-hidden">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl mx-auto flex flex-col lg:flex-row shadow-2xl rounded-3xl overflow-hidden bg-white">

        <!-- LEFT -->
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
                   Tạo tài khoản để bắt đầu hành trình thời trang cùng chúng tôi!
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

        <!-- RIGHT -->
        <div class="lg:w-1/2 bg-white flex items-center justify-center p-8"
             x-data="{
                step: 1,
                phone: '',
                email: '',
                otp: '',
                loading: false,

                async sendOTP() {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route('register.send-otp') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ phone: this.phone, email: this.email })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            alert(data.message || 'Đã gửi OTP');
                            this.step = 2;
                        } else {
                            alert(data.message || 'Lỗi gửi OTP');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Có lỗi xảy ra khi gửi OTP');
                    } finally {
                        this.loading = false;
                    }
                },

                // ====================== SỬA Ở ĐÂY ======================
                async verifyOTP() {
                    if (!this.otp || this.otp.length !== 6) {
                        alert('Vui lòng nhập đủ 6 số OTP');
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch('{{ route('register.verify-otp') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({
                                email: this.email,
                                otp: this.otp
                            })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            alert(data.message || 'Xác thực thành công!');
                            // Redirect
                            window.location.href = '{{ route("register.complete") }}';
                        } else {
                            alert(data.error || data.message || 'OTP không đúng hoặc đã hết hạn');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Lỗi kết nối. Vui lòng thử lại!');
                    } finally {
                        this.loading = false;
                    }
                }
             }"
        >

            <div class="w-full max-w-md space-y-8">

                <!-- STEP 1 -->
                <div x-show="step === 1">
                    <h2 class="font-serif text-4xl text-black">ĐĂNG KÝ</h2>
                    <p class="text-gray-600 mt-2">Nhập thông tin để nhận mã OTP</p>

                    <form @submit.prevent="sendOTP()" class="space-y-6 mt-8">
                        <input type="tel" x-model="phone" required
                               class="w-full px-4 py-4 border rounded-2xl"
                               placeholder="Số điện thoại">

                        <input type="email" x-model="email" required
                               class="w-full px-4 py-4 border rounded-2xl"
                               placeholder="Email">

                        <button type="submit" :disabled="loading"
                                class="w-full bg-[#1a2744] text-white py-4 rounded-2xl">
                            <span x-show="!loading">GỬI OTP</span>
                            <span x-show="loading">Đang gửi...</span>
                        </button>
                    </form>
                </div>

                <!-- STEP 2 -->
                <div x-show="step === 2">
                    <h2 class="font-serif text-4xl">Nhập OTP</h2>

                    <input type="text" maxlength="6" x-model="otp"
                           class="w-full px-4 py-4 border rounded-2xl text-center mt-6"
                           placeholder="000000">

                    <button @click="verifyOTP()"
                            class="w-full bg-[#1a2744] text-white py-4 rounded-2xl mt-6">
                        XÁC NHẬN
                    </button>

                    <button @click="step = 1"
                            class="text-gray-500 mt-4">
                        ← Quay lại
                    </button>
                </div>

                <p class="text-center text-gray-500 text-sm">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="text-[#1a2744]">Đăng nhập</a>
                </p>

            </div>
        </div>
    </div>
</div>

</body>
</html>
