@extends('admin.dashboard')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.sizes.index') }}">Kích thước</a></li>
                    <li class="breadcrumb-item active">Sửa kích thước</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Sửa kích thước</h4>
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
                                <form class="form-valide" action="{{ route('admin.sizes.update', $size->id) }}" method="post">
                                    @method('PUT')
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label text-lg-right" for="size_name">
                                            Tên kích thước <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text"
                                                   class="form-control @error('size_name') is-invalid @enderror"
                                                   id="size_name"
                                                   name="size_name"
                                                   value="{{ old('size_name', $size->size_name) }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group row" style="flex-direction: row-reverse;">
                                        <div class="col-lg-8 mb-3">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                        <div class="col-lg-8">
                                            <a href="{{ route('admin.sizes.index') }}" class="btn btn-success">Quay lại</a>
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
