@extends('admin.dashboard')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h4 class="card-title">Chỉnh sửa danh mục</h4>

                            <form class="form-valide" action="{{ route('admin.categories.update', $category->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <!-- Tên danh mục -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="category_name">
                                        Tên Danh mục <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="category_name"
                                               name="category_name" value="{{ old('category_name', $category->category_name) }}" required>
                                    </div>
                                </div>

                                <!-- Danh mục cha -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">
                                        Danh mục cha <br>
                                        <small class="text-muted">(Có thể chọn nhiều)</small>
                                    </label>
                                    <div class="col-lg-7">
                                        <div class="border p-3 bg-light category-tree" style="max-height: 450px; overflow-y: auto;">
                                            {!! $categoryTreeHtml ?? '' !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="description">Mô tả</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Thứ tự -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="order">Level</label>
                                    <div class="col-lg-7">
                                        <input type="number" readonly class="form-control" name="level" value="{{ old('level', $category->level) }}" min="0">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
