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
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add new member</h4>
                            <div class="form-validation">
                                <form class="form-valide" action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">Image url <span class="text-danger"></span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control" id="val-username" name="url" value="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-skill">Level <span class="text-danger"></span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="val-skill" name="product_variant_id">
                                                <option>Please select</option>
                                                @foreach($variants as $variant)
                                                    <option value="{{$variant->id}}">
                                                        {{$variant->product->product_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="submit" name="submit" class="btn btn-primary">Add new</button>
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