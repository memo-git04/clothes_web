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
                            <h4 class="card-title">Thêm mới danh mục</h4>

                            <form class="form-valide" action="{{ route('admin.categories.store') }}" method="post">
                            @csrf

                            <!-- Tên danh mục -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="category_name">
                                        Tên Danh mục <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" id="category_name"
                                               name="category_name" required placeholder="Ví dụ: Đồ công sở">
                                    </div>
                                </div>

                                <!-- Nested Checkbox - Chọn nhiều cha -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">
                                        Danh mục cha <br>
                                        <small class="text-muted">(Có thể chọn nhiều)</small>
                                    </label>
                                    <div class="col-lg-7">
                                        <div class="border p-3 bg-light category-tree"
                                             style="max-height: 450px; overflow-y: auto;">
                                            {!! $categoryTreeHtml ?? '' !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="description">Mô tả</label>
                                    <div class="col-lg-7">
                                        <textarea class="form-control" name="description" rows="3" placeholder="Mô tả danh mục..."></textarea>
                                    </div>
                                </div>

                                <!-- Thứ tự -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right" for="order">Thứ tự hiển thị</label>
                                    <div class="col-lg-7">
                                        <input type="number" class="form-control" name="order" value="0" min="0">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
