@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    @can('role.edit')
                        <h4 class="card-title mb-4">
                            Gán quyền cho vai trò: <strong>{{ $role->name }}</strong>
                        </h4>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.roles.permissions.update', $role->id) }}">
                            @csrf

                            @foreach($permissions as $module => $perms)
                                <div class="mb-4">

                                    <h5 class="bg-light p-2 rounded">
                                        {{ strtoupper($module) }}
                                    </h5>

                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            @foreach($perms as $perm)
                                                <th>
                                                    @php
                                                        $parts = explode('.', $perm->name);
                                                    @endphp
                                                    {{ ucfirst($parts[1] ?? $parts[0]) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            @foreach($perms as $perm)
                                                <td>
                                                    <input
                                                        type="checkbox"
                                                        name="permissions[]"
                                                        value="{{ $perm->name }}"
                                                        {{ $role->permissions->pluck('name')->contains($perm->name) ? 'checked' : '' }}
                                                    >
                                                </td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            @endforeach

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save"></i> Lưu phân quyền
                                </button>

                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fa-solid fa-arrow-left"></i> Quay lại
                                </a>
                            </div>

                        </form>
                    @else
                    <!-- HIỂN THỊ THÔNG BÁO CHO MANAGER -->
                        <div class="alert alert-danger text-center">
                            <h4><i class="fas fa-exclamation-triangle"></i> Cảnh báo!</h4>
                            <p>Bạn không có quyền truy cập chức năng này</p>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
                        </div>
                    @endcan
                </div>
            </div>

        </div>
    </div>
@endsection
