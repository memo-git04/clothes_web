@extends('admin.dashboard')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Color</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thêm mới màu</h4>

                            <form class="form-valide" action="{{ route('admin.colors.store') }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="color_name">
                                        Tên màu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text"
                                               class="form-control"
                                               id="color_name"
                                               name="color_name"
                                               placeholder="Nhập tên màu (ví dụ: Đỏ, Xanh Navy...)"
                                               required>
                                    </div>
                                </div>

                                <!-- Phần nút bấm -->
                                <div class="form-group row">
                                    <div class="col-lg-3"></div>  <!-- Để căn chỉnh với label -->
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                        <a href="{{ route('admin.colors.index') }}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
