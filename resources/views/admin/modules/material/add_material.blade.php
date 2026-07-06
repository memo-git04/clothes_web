@extends('admin.dashboard')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.materials.index') }}">Chất liệu</a></li>
                    <li class="breadcrumb-item active">Thêm mới chất liệu</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thêm mới chất liệu</h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="form-valide" action="{{ route('admin.materials.store') }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="material_name">
                                        Tên chất liệu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               class="form-control @error('material_name') is-invalid @enderror"
                                               id="material_name"
                                               name="material_name"
                                               placeholder="Nhập tên chất liệu (ví dụ: Cotton, Polyester, Da...)"
                                        >
                                    </div>
                                </div>

                                <!-- Phần nút bấm -->
                                <div class="form-group row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                        <a href="{{ route('admin.materials.index') }}" class="btn btn-danger">Hủy</a>
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
