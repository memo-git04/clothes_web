@extends('layouts.app')
@section('content')
    <div class="max-w-5xl mx-auto px-4" style="margin-top: 140px; margin-bottom: 100px;">
        <div class="text-center mb-10">
            <h1 class="font-serif text-4xl font-light tracking-tight">Thông tin tài khoản</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 text-sm text-emerald-700 bg-emerald-50 border border-emerald-100 py-3 px-4 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-100 py-3 px-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            @method('PUT')

            <!-- Avatar -->
            <div class="lg:col-span-1">
                <div class="border border-gray-100 rounded-2xl p-6 text-center">
                    <img id="previewImg"
                         src="{{ $customer->img ? asset('storage/' . $customer->img) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->full_name) . '&background=111&color=fff&size=256' }}"
                         class="w-40 h-40 rounded-full object-cover mx-auto mb-4 border" alt="Avatar">
                    <p class="font-medium">{{ $customer->full_name }}</p>
                    <p class="text-xs text-gray-500 mb-4">{{ $customer->email }}</p>
                    <label class="inline-block cursor-pointer text-[11px] uppercase tracking-[0.2em] border border-black px-4 py-2 hover:bg-black hover:text-white transition">
                        Đổi ảnh
                        <input type="file" name="img" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
            </div>

            <!-- Fields -->
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Tên đăng nhập</label>
                        <input type="text" class="w-full border border-gray-200 py-2.5 px-3 bg-gray-50 text-gray-600" value="{{ $customer->user_name }}" readonly>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Họ và tên</label>
                        <input type="text" name="full_name" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black" value="{{ old('full_name', $customer->full_name) }}">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Email</label>
                        <input type="email" class="w-full border border-gray-200 py-2.5 px-3 bg-gray-50 text-gray-600" value="{{ $customer->email }}" readonly>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Số điện thoại</label>
                        <input type="text" name="phone" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black" value="{{ old('phone', $customer->phone) }}">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Giới tính</label>
                        <select name="gender" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black">
                            <option value="">-- Chọn --</option>
                            <option value="male"   @selected($customer->gender === 'male')>Nam</option>
                            <option value="female" @selected($customer->gender === 'female')>Nữ</option>
                            <option value="other"  @selected($customer->gender === 'other')>Khác</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Ngày sinh</label>
                        <input type="date" name="date_of_birth" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black"
                               value="{{ old('date_of_birth', $customer->date_of_birth ? \Illuminate\Support\Carbon::parse($customer->date_of_birth)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Địa chỉ</label>
                        <input type="text" name="address" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black" value="{{ old('address', $customer->address) }}">
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">Đổi mật khẩu (bỏ trống nếu không đổi)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Mật khẩu mới</label>
                            <input type="password" name="password" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-1">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="w-full border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-black">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="px-8 py-3 bg-black text-white text-[11px] uppercase tracking-[0.2em] hover:opacity-80 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const previewImg = document.getElementById('previewImg');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => previewImg.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
