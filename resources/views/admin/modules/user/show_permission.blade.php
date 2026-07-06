@extends('admin.dashboard')
@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
                    <li class="breadcrumb-item active">Quyền của người dùng</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Quyền hạn của tài khoản</h4>

                            <div class="form-validation">
                                <!-- Thông tin người dùng -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Tên người dùng</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" value="{{ $user->full_name }}" disabled>
                                    </div>
                                </div>

                                <!-- Danh sách quyền -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Danh sách quyền</label>
                                    <div class="col-lg-6">
                                        @if($allPermissions->isEmpty())
                                            <p class="text-muted">Người dùng này chưa có quyền nào.</p>
                                        @else
                                            <ul class="list-group">
                                                @foreach($allPermissions as $permission)
                                                    <li class="list-group-item">
                                                        {{ $permission->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                                <!-- Nút quay lại -->
                                <div class="form-group row" style="flex-direction: row-reverse;">
                                    <div class="col-lg-8">
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
