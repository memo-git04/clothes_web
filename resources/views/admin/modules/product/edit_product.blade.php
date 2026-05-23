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

        <div class="container-fluid ">
            <div class="row justify-content-center">
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit product</h4>
                            <div class="form-validation">

                                <form class="form-valide" action="{{route('products.update', $product->id)}}" method="post"
                                      enctype="multipart/form-data" style="display: flex">
                                    @method('PUT')
                                    @csrf
                                    <div class="col-sm-5">

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Product Name</b></label>
                                            <input type="text" name="edit_name" value="{{$product->product_name}}" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Base Price</b></label>
                                            <input type="text" name="edit_base_price" value="{{$product->base_price}}" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Category</b></label>
                                            <select name="edit_category" class="form-control" readonly>
                                                <option value="{{$product->category->id}}" selected>
                                                    {{$product->category->category_name}}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Material</b></label>
                                            <select name="edit_material" class="form-control" readonly>
                                                <option value="{{$product->material->id}}">
                                                    {{$product->material->material_name}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Brand</b></label>
                                            <select name="edit_brand" class="form-control" readonly>
                                                <option value="{{$product->brand->id}}">
                                                    {{$product->brand->brand_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="mb-3">
                                            <label for="exampleFormControlFile1"><b>Origin</b></label>
                                            <select name="edit_origin" class="form-control" readonly>
                                                <option value="{{$product->origin->id}}">
                                                    {{$product->origin->origin_name}}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1"><b>Description </b></label>
                                            <textarea name="edit_description"  class="form-control" >
                                                {!! $product->description !!}
                                            </textarea>
                                        </div>


                                        @foreach($variants as $index => $variant)
                                            <div class="form-group" data-variant-id="{{ $variant->id }}">
                                                <input type="hidden" name="edit_variant[{{ $loop->index }}][id]" value="{{ $variant->id }}">
                                                <label for="color"><b>Color</b></label>
                                                <input type="text" value="{{ $variant->color->color_name }}" class="form-control" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="size"><b>Size</b></label>
                                                <input type="text" value="{{ $variant->size->size_name }}" class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="price"><b>Price</b></label>
                                                <input type="text" name="edit_variant[{{ $loop->index }}][price]" value="{{ $variant->price }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity"><b>Stock quantity</b></label>
                                                <input type="text" name="edit_variant[{{ $loop->index }}][quantity]" value="{{ $variant->stock_quantity }}" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="quantity"><b>Current Images</b></label>
                                                <ul>
                                                    @foreach ($variant->images as $image)
                                                        <li>
                                                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url('images/') . $image->url) }}" alt="Image" width="100"/>
                                                            <span>{{ basename($image->url) }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach

                                        <div class="form-group row" style="margin-left: 465px">
                                            <div class="col-lg-8 ml-auto mb-3">
                                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            </div>
                                            <div class="col-lg-8 ml-auto">
                                                <a href="{{ route('products.index') }}" class="btn btn-success">Back</a>
                                            </div>
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


        <script>
            function previewImage() {
                prd_image.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
        <!--**********************************
@endsection