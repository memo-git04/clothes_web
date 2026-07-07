@extends('admin.dashboard')
@section('content')

    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Tài khoản</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Danh sách tài khoản</h4>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Vai trò</th>

                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin->full_name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone ?? 'Chưa cập nhật' }}</td>
                                            <td>
                                                @if($admin->roles->isNotEmpty())
                                                    @foreach($admin->roles as $role)
                                                        <button type="button" class="btn btn-success btn-sm">
                                                            {{ $role->name }}
                                                        </button>
                                                    @endforeach
                                                @else
                                                    <button type="button" class="btn btn-secondary btn-sm">Chưa có vai trò</button>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex gap-2">
                                                    <!-- Edit -->
                                                    @can('user.edit')
                                                        <a href="{{ route('admin.users.edit', $admin->id) }}">
                                                            <button type="button" class="btn btn-primary btn-sm" style="margin-right: 8px">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                    <!-- Delete -->
                                                    @can('user.delete')
                                                    <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST"
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                    @endcan

                                                    <!-- View Permissions -->
                                                    @can('user.view')
                                                    <a href="{{ route('admin.users.show.permissions', $admin->id) }}">
                                                        <button type="button" class="btn btn-info btn-sm" style="margin-left: 8px">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Vai trò</th>

                                        <th>Thao tác</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            @can('user.create')
                                <!-- Button Add New -->
                                <div class="add mt-3">
                                    <a href="{{ route('admin.users.create') }}">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa-solid fa-plus"></i> Thêm tài khoản mới
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
