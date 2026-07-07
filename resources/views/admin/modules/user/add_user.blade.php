@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm tài khoản</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('user.create')
                            <h4 class="card-title">Thêm tài khoản mới</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="form-valide" action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            <!-- Tên đăng nhập -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Tên đăng nhập <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               class="form-control @error('user_name') is-invalid @enderror"
                                               name="user_name"
                                               value="{{ old('user_name') }}"
                                               >
                                    </div>
                                </div>

                                <!-- Họ và tên -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Họ và tên <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               class="form-control @error('full_name') is-invalid @enderror"
                                               name="full_name"
                                               value="{{ old('full_name') }}"
                                               >

                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}"
                                               >

                                    </div>
                                </div>

                                <!-- Mật khẩu -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Mật khẩu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <div class="input-group">
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password"
                                                   >
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Xác nhận mật khẩu -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Xác nhận mật khẩu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <div class="input-group">
                                            <input type="password"
                                                   class="form-control"
                                                   name="password_confirmation"
                                                   >
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Số điện thoại <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="tel"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               pattern="[0-9]{10,11}"
                                               >

                                    </div>
                                </div>

                                <!-- Giới tính -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Giới tính <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <select class="form-control @error('gender') is-invalid @enderror"
                                                name="gender"
                                                >
                                            <option value="">-- Chọn --</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                        </select>

                                    </div>
                                </div>

                                <!-- Ngày sinh -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Ngày sinh <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="date"
                                               class="form-control @error('date_of_birth') is-invalid @enderror"
                                               name="date_of_birth"
                                               max="{{ date('Y-m-d') }}"
                                               >

                                    </div>
                                </div>

                                <!-- Địa chỉ -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Địa chỉ <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control @error('address') is-invalid @enderror"
                                                  name="address"
                                                  rows="3"
                                                  >{{ old('address') }}</textarea>

                                    </div>
                                </div>

                                <!-- Vai trò -->
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label">
                                        Vai trò <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <select name="role"
                                                class="form-control @error('role') is-invalid @enderror"
                                                >
                                            <option value="">-- Chọn vai trò --</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ old('role') == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Thêm tài khoản
                                        </button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                                            <i class="fas fa-arrow-left"></i> Quay lại
                                        </a>
                                    </div>
                                </div>
                            </form>

                            @else
                                <div class="alert alert-danger text-center">
                                    <h4><i class="fas fa-exclamation-triangle"></i> Cảnh báo!</h4>
                                    <p>Bạn không có quyền truy cập chức năng này</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
                                </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Form validation (Sửa lỗi crash trang khi Manager vào)
        const userForm = document.querySelector('form.form-valide');
        if(userForm) {
            userForm.addEventListener('submit', function(e) {
                const password = document.querySelector('input[name="password"]').value;
                const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Mật khẩu xác nhận không khớp');
                    return false;
                }

                const phone = document.querySelector('input[name="phone"]').value;
                const phoneRegex = /^[0-9]{10,11}$/;
                if (!phoneRegex.test(phone)) {
                    e.preventDefault();
                    alert('Số điện thoại không hợp lệ (10-11 số)');
                    return false;
                }

                const dob = new Date(document.querySelector('input[name="date_of_birth"]').value);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();

                if (age < 18) {
                    e.preventDefault();
                    alert('Người dùng phải từ 18 tuổi trở lên');
                    return false;
                }
            });
        }
    </script>

@endsection
