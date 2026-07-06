@extends('admin.dashboard')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.brands.index') }}">Thương hiệu</a></li>
                    <li class="breadcrumb-item active">Sửa thương hiệu</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sửa thương hiệu</h4>
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
                                <form class="form-valide" action="{{ route('admin.brands.update', $brand->id) }}" method="post">
                                    @method('PUT')
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-lg-right" for="brand_name">
                                            Tên thương hiệu <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-7">
                                            <input type="text"
                                                   class="form-control @error('brand_name') is-invalid @enderror"
                                                   id="brand_name"
                                                   name="brand_name"
                                                   value="{{ old('brand_name', $brand->brand_name) }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row" style="flex-direction: row-reverse;">
                                        <div class="col-lg-9 mb-3">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                        <div class="col-lg-9">
                                            <a href="{{ route('admin.brands.index') }}" class="btn btn-success">Quay lại</a>
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
