@extends('admin.dashboard')
@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active">Phân quyền</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Phân quyền cho tài khoản</h4>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-validation">
                                <form class="form-valide" action="{{ route('admin.users.permissions.post', $user->id) }}" method="POST">
                                @csrf

                                <!-- Thông tin người dùng -->
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Tên người dùng</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" value="{{ $user->full_name }}" disabled>
                                        </div>
                                    </div>

                                    <!-- Danh sách quyền -->
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Các quyền hạn</label>
                                        <div class="col-lg-6">
                                            @foreach($permissions as $permission)
                                                <div class="checkbox mb-2">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                            {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Nút hành động -->
                                    <div class="form-group row" style="flex-direction: row-reverse;">
                                        <div class="col-lg-8 mb-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-save"></i> Lưu phân quyền
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
