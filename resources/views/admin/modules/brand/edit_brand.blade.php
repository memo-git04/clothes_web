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
                            <h4 class="card-title">Edit brand</h4>
                            <div class="form-validation">
                                <form class="form-valide" action="{{ route('brands.update', $brand->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Name<span class="text-danger"></span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="val-username" name="edit_brand" value="{{ $brand->brand_name }}">
                                        </div>

                                    </div>

                                    <div class="form-group row" style="flex-direction:row-reverse;">
                                        <div class="col-lg-8 mb-3">
                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                        </div>
                                        <div class="col-lg-8">
                                            <a href="{{ route('brands.index') }}" class="btn btn-success">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
@endsection