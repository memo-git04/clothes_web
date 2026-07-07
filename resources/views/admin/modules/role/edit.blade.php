@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Vai trò</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa vai trò</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @can('role.edit')
                                <h4 class="card-title">Chỉnh sửa vai trò</h4>

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Tên vai trò -->
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">
                                            Tên vai trò <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="name"
                                                value="{{ old('name', $role->name) }}"
                                                required
                                            >
                                            @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-save"></i> Cập nhật vai trò
                                            </button>
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary ml-2">
                                                Hủy
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            @else
                            <!-- HIỂN THỊ THÔNG BÁO CHO MANAGER -->
                                <div class="alert alert-danger text-center">
                                    <h4><i class="fas fa-exclamation-triangle"></i> Cảnh báo!</h4>
                                    <p>Bạn không có quyền truy cập chức năng này</p>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
