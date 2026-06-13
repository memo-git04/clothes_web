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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Role List</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Add Permission</th>
                                        <th>Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $roles as $role)
                                        <tr>
                                            <td style="">{{$loop->iteration}}</td>
                                            <td style="">{{$role->name}}</td>
                                            <td>
                                                <a href="{{ route('roles.create', $role->id) }}" class="btn btn-primary">Add Permission</a>
                                            </td>
                                            <td>
                                                <a href="{{route('roles.edit', $role->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <form action="{{route('roles.destroy', $role->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Add Permission</th>
                                        <th>Act</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Button Add New Product -->
                            <div class="add mt-2 mx-4">
                                <a href="{{route('roles.create')}}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Tạo vai trò mới</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
