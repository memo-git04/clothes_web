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
                            <h4 class="card-title">List of materials</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td>
                                                {{ $material->id }}
                                            </td>
                                            <td>
                                                {{ $material->material_name }}
                                            </td>
                                            <td>
                                                <a href=" {{ route('materials.edit', $material->id) }} "><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <form action="{{ route('materials.destroy',$material->id ) }}" method="POST">
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
                                        <th>Act</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="add mt-2 mx-4">
                                <a href="{{ route('materials.create') }}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add new material</button></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
