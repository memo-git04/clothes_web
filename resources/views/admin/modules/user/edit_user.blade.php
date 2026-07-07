@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa tài khoản</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @can('user.edit')
                                <h4 class="card-title">Chỉnh sửa tài khoản</h4>

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="form-validation">
                                    <form class="form-valide" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    <!-- Họ và tên -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text"
                                                       class="form-control"
                                                       name="full_name"
                                                       value="{{ old('full_name', $user->full_name) }}"
                                                       required>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Email <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="email"
                                                       class="form-control"
                                                       name="email"
                                                       value="{{ old('email', $user->email) }}"
                                                       required>
                                            </div>
                                        </div>

                                        <!-- Mật khẩu -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Mật khẩu</label>
                                            <div class="col-lg-6">
                                                <input type="password"
                                                       class="form-control"
                                                       name="password">
                                                <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                                            </div>
                                        </div>

                                        <!-- Xác nhận mật khẩu -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Xác nhận mật khẩu</label>
                                            <div class="col-lg-6">
                                                <input type="password"
                                                       class="form-control"
                                                       name="password_confirmation">
                                            </div>
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Số điện thoại</label>
                                            <div class="col-lg-6">
                                                <input type="text"
                                                       class="form-control"
                                                       name="phone"
                                                       value="{{ old('phone', $user->phone ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Địa chỉ -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Địa chỉ</label>
                                            <div class="col-lg-6">
                                                <input type="text"
                                                       class="form-control"
                                                       name="address"
                                                       value="{{ old('address', $user->address ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Vai trò -->
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Vai trò <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                @foreach($roles as $role)
                                                    <div class="checkbox mb-2">
                                                        <label>
                                                            <input type="checkbox"
                                                                   name="roles[]"
                                                                   value="{{ $role->name }}"
                                                                {{ (in_array($role->name, old('roles', $user->roles->pluck('name')->toArray()))) ? 'checked' : '' }}>
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Nút hành động -->
                                        <div class="form-group row" style="flex-direction: row-reverse;">
                                            <div class="col-lg-8 mb-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-save"></i> Cập nhật tài khoản
                                                </button>
                                            </div>
                                            <div class="col-lg-8">
                                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                                    <i class="fa-solid fa-arrow-left"></i> Quay lại
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                            <!-- HIỂN THỊ THÔNG BÁO CHO MANAGER -->
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
@endsection
