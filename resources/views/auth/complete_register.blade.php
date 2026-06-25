@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <div  style="margin-top: 100px" class="w-full max-w-5xl mx-auto flex flex-col lg:flex-row shadow-2xl rounded-3xl overflow-hidden bg-white">

            <!-- LEFT SECTION -->
            <div class="lg:w-1/2 bg-[#1a2744] relative flex flex-col justify-between p-8 lg:p-16 min-h-[420px] lg:min-h-screen"
                 >
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

            <!-- RIGHT SECTION - COMPLETE INFO -->
            <div class="lg:w-1/2 bg-white flex items-center justify-center p-8 lg:p-12">
                <div class="w-full max-w-md space-y-6">
                    <h2 class="font-serif text-4xl text-black font-light">Hoàn thiện đăng ký</h2>
                    <p class="text-gray-600">Vui lòng điền thông tin cá nhân</p>

                    <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tên đăng nhập (Username)</label>
                            <input type="text" name="user_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Họ và tên</label>
                            <input type="text" name="full_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Mật khẩu</label>
                                <input type="password" name="password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Nhập lại mật khẩu</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Giới tính</label>
                            <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                                <option value="">Chọn giới tính</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ngày sinh</label>
                            <input type="date" name="date_of_birth"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]">
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Địa chỉ</label>
                            <textarea name="address" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:border-[#1a2744]"></textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-[#1a2744] hover:bg-[#14203a] text-white py-4 rounded-2xl font-medium tracking-wider text-sm transition-colors">
                            HOÀN TẤT ĐĂNG KÝ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
