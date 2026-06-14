@extends('admin.layouts.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('permissions.index') }}">Permissions</a>
                    </li>
                    <li class="breadcrumb-item active">Gán Role cho Permission</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Gán Role cho Permission</h4>

                            {{-- Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

{{--                            @can('Role Has Permission')--}}

                                <form method="POST" action="{{ route('permissions.assign.store', $permission->id) }}">
                                    @csrf

                                    {{-- Permission name --}}
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">
                                            Permission
                                        </label>
                                        <div class="col-lg-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ $permission->name }}"
                                                disabled
                                            >
                                        </div>
                                    </div>

                                    {{-- Roles --}}
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">
                                            Roles
                                        </label>
                                        <div class="col-lg-8">

                                            @foreach($roles as $role)
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="roles[]"
                                                        value="{{ $role->id }}"
                                                        id="role_{{ $role->id }}"
                                                        {{ $permission->roles->contains($role->id) ? 'checked' : '' }}
                                                    >

                                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                                        {{ $role->name }}
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" class="btn btn-primary">
                                                Gán Role
                                            </button>

                                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                                                Hủy
                                            </a>
                                        </div>
                                    </div>

                                </form>

{{--                            @else--}}
{{--                                <div class="alert alert-danger">--}}
{{--                                    <strong>Sorry!</strong> Bạn không có quyền gán role cho permission.--}}
{{--                                </div>--}}
{{--                            @endcan--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
