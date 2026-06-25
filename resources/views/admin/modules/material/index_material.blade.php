@extends('admin.dashboard')
@section('content')
     <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Material</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Bảng Chất liệu</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td>
                                                {{$loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $material->material_name }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <!-- Button Edit -->
                                                    <a href=" {{ route('admin.materials.edit', $material->id) }} ">
                                                        <button type="button" class="btn btn-primary btn-sm" style="margin-right: 10px">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Button Delete -->
                                                    <form action="{{ route('admin.materials.destroy',$material->id ) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Act</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="add mt-2 mx-4">
                                <a href="{{ route('admin.materials.create') }}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add new material</button></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
