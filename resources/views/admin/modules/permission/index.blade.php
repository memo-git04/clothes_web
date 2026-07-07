@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Quyền hạn</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Danh sách quyền hạn</h4>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên quyền</th>

                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                @can('role.edit')
                                                    <div class="d-flex gap-2">
                                                        <!-- Edit -->
                                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}">
                                                            <button type="button" class="btn btn-primary btn-sm" style="margin-right: 8px">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </a>

                                                        <!-- Delete -->
                                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                              method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa quyền này không?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Không có quyền</span>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên quyền</th>

                                        <th>Thao tác</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Nút thêm mới -->
                            @can('role.create')
                                <div class="add mt-3">
                                    <a href="{{ route('admin.permissions.create') }}">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa-solid fa-plus"></i> Thêm quyền mới
                                        </button>
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
