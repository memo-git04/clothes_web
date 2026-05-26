@extends('admin.layouts.dashboard')
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
                    <h4 class="card-title">Edit member</h4>

                    <div class="form-validation">
                        <form class="form-valide" action="{{ route('users.update', $admin->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-username">Username <span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="edit_username" value="{{ $admin->username}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-username">Fullname <span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="edit_fullname" value="{{ $admin->full_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-email">Email <span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-email" value="{{ $admin->email}}" name="edit_email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-skill">Level <span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="val-skill" name="edit_role">
{{--                                        <option>Please select</option>--}}
                                        @foreach($roles as $role)
                                            @if($admin->role_id == $role->id)
                                                <option selected value="{{$role->id}} " >
                                                    {{$role->role_name}}
                                                </option>
                                            @else
                                            <option value="{{$role->id}}" >
                                                {{$role->role_name}}
                                            </option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-phone">Phone<span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-phone" value="{{ $admin->phone}}" name="edit_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="val-address">Address<span class="text-danger"></span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-address" value="{{ $admin->address}}" name="edit_address">
                                </div>
                            </div>
                            <div class="form-group row" style="flex-direction:row-reverse;">
                                <div class="col-lg-8 mb-3">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                                <div class="col-lg-8">
                                    <a href="{{ route('users.index') }}" class="btn btn-success">Back</a>
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
