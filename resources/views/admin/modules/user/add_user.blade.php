@extends('admin.dashboard')
@section('content')

    <div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add new member</h4>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
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
                            <form class="form-valide" action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                {{-- Username --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Username</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="user_name" value="{{ old('user_name') }}">
                                        @error('user_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Full name --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Fullname</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}">
                                        @error('full_name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Email</label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Password</label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Confirm Password --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Confirm Password</label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Phone</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                    </div>
                                </div>

                                {{-- Gender --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Gender</label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="gender">
                                            <option value="">-- Select --</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Date of birth --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Date of Birth</label>
                                    <div class="col-lg-6">
                                        <input type="date" class="form-control" name="date_of_birth">
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Address</label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" name="address">{{ old('address') }}</textarea>

                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Add new</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
