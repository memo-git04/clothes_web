@extends('admin.layouts.dashboard')

@section('content')

    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permission</a></li>
                    <li class="breadcrumb-item active">Edit Permission</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Permission</h4>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Tên Permission -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Tên Vai Trò <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            value="{{ old('name', $permission->name) }}"
                                            required
                                        >
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Hủy</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        ```

    </div>
@endsection
