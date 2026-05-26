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
                        <div class="card-body ">
                            <h4 class="card-title mb-3">Product Detail</h4>

                            <div style="display: flex">
                                <div class="col-sm-5">

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1"><b>Name: </b>{{$product->product_name}}</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1"><b>Base Price: </b>$ {{ number_format($product->base_price, 0, ',', '.')}} VND</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Category: {{$product->category->category_name}}</b></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Material: {{$product->material->material_name}}</b></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Brand: {{$product->brand->brand_name}}</b> </label>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="mb-3 mt-3">
                                        <label for="exampleFormControlFile1"><b>Origin: {{$product->origin->origin_name}}</b> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Description: {{$product->description}}</b> </label>
                                    </div>
                                    @foreach($variants as $variant  )
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Selling Price: </b> {{ number_format($variant->price, 2, ',', '.')}} VND</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Stock Quantity: {{$variant->stock_quantity}}</b></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Color: {{$variant->color->color_name}}</b> </label>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Size: {{$variant->size->size_name}}</b> </label>
                                        </div>

                                        <div class="form-group">
                                            @foreach ($variant->images as $image)
                                                <img src="{{ asset('storage/' . $image->url) }}" alt="Image of {{ $variant->color->name }} - {{ $variant->size->name }}" width="100">
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div  style="display: flex">
                                <div class="add mt-2 mx-4">
                                    <a href="{{route('products.index')}}"><button type="button" class="btn btn-success"> Back </button></a>
                                </div>
                                <div class="add mt-2 mx-4">
                                    <a href="{{route('products.edit', $product->id) }}"><button type="button" class="btn btn-primary"> Edit </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
