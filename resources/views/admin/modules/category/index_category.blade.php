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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Danh sách danh mục</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên Danh mục</th>
                                            <th>Danh mục cha</th>
                                            <th>Level</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>
                                                @if($category->parents->isNotEmpty() || $category->getAllParents()->isNotEmpty())
                                                    @foreach($category->getAllParents() as $parent)
                                                        <span class="badge bg-lgreen mb-1">{{ $parent->category_name }}</span>
                                                    @endforeach

{{--                                                    @if($category->parents->isNotEmpty())--}}
{{--                                                        <br><small class="text-muted">Trực tiếp: </small>--}}
{{--                                                        @foreach($category->parents as $direct)--}}
{{--                                                            <span class="badge bg-success-rgba1 mb-1">{{ $direct->category_name }}</span>--}}
{{--                                                        @endforeach--}}
{{--                                                    @endif--}}
                                                @else
                                                    <span class="text-success">Danh mục gốc</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-dark" style="align: center">{{ $category->level }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.categories.edit', $category->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>

                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên Danh mục</th>
                                            <th>Danh mục cha</th>
                                            <th>Level</th>
                                            <th>Hành động</th>
                                        </tr>
                                </table>
                            </div>

                            <div class="add mt-2 mx-4">
                                <a href="{{ route('admin.categories.create') }}">
                                    <button type="button" class="btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Thêm mới danh mục
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
