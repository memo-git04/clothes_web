@extends('admin.layouts.adminapp')
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
                    <h4 class="card-title">Member List</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Level</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach( $admins as $admin)
                                 <tr>
                                     <td style="">{{$admin->id}}</td>
                                     <td style="">{{$admin->full_name}}</td>
                                     <td style="">{{$admin->email}}</td>
                                     <td style="">{{$admin->phone}}</td>
                                     <td style="">{{$admin->address}}</td>
                                     <td>
                                         <button type="button" class="btn btn-success btn-sm">
                                             {{$admin->role->role_name}}
                                         </button>
{{--                                         <button type="button" class="btn btn-primary btn-sm">--}}
{{--                                             Member--}}
{{--                                         </button>--}}
                                     </td>
                                     <td>
                                         <a href="{{route('users.edit', $admin->id) }}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                         <form action="{{route('users.destroy', $admin->id)}}" method="post">
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
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Level</th>
                                    <th>Act</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Button Add New Product -->
                    <div class="add mt-2 mx-4">
                        <a href="{{route('users.create')}}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add new member</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection