@extends('admin.dashboard')

@section('content')

    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.permissions.index') }}">Quyền hạn</a>
                    </li>
                    <li class="breadcrumb-item active">Thêm quyền mới</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Thêm quyền mới</h4>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.permissions.store') }}" method="POST">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Tên quyền <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder="Ví dụ: product.create"
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
                                            <i class="fa-solid fa-plus"></i> Thêm quyền
                                        </button>
                                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary ml-2">
                                            Hủy
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

@endsection
