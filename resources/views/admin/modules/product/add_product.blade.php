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

        <div class="container-fluid ">
            <div class="row justify-content-center">
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add new product</h4>
                            <div class="form-validation">

                                <form class="form-valide" action="{{route('products.store')}}" method="post"
                                      enctype="multipart/form-data" style="display: flex">
                                    @csrf
{{--                                    LEFT--}}
                                    <div class="col-sm-5">

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Product Name</b></label>
                                            <input type="text" name="product_name" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Category</b></label>
                                            <select name="category_id" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">
                                                        {{$category->category_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Material</b></label>
                                            <select name="material_id" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($materials as $material)
                                                    <option value="{{$material->id}}">
                                                        {{$material->material_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Brand</b></label>
                                            <select name="brand_id" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">
                                                        {{$brand->brand_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Color</b></label>
                                            <select name="variants[0][color_id]" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($colors as $color)
                                                    <option value="{{$color->id}}">
                                                        {{$color->color_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Size</b></label>
                                            <select name="variants[0][size_id]" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($sizes as $size)
                                                    <option value="{{$size->id}}">
                                                        {{$size->size_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
{{--                                    RIGHT--}}
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1"><b>Description </b></label>
                                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Base Price</b></label>
                                            <input type="text" name="variants[0][base_price]" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>SKU</b></label>
                                            <input type="text" name="variants[0][sku]" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Selling Price</b></label>
                                            <input type="text" name="variants[0][selling_price]" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Origin Price</b></label>
                                            <input type="text" name="variants[0][original_price]" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Stock quantity</b></label>
                                            <input type="text" name="variants[0][stock_quantity]" class="form-control" id="exampleFormControlInput1">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Image</b></label>
                                            <input type="file" name="variants[0][images][]" multiple onchange="previewImages(event)">
                                            <br>
                                            <div id="preview-container">
                                                <img id="preview" width="150" style="margin-top:10px;">
                                            </div>

                                        </div>


                                        <div class="form-group row" style="margin-left: 465px">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" name="submit" class="btn btn-primary">Add new</button>
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
            function previewImages(event) {
                // prd_image.src = URL.createObjectURL(event.target.files[0]);
                const container = document.getElementById('preview-container');
                // container.innerHTML = ""; // reset ảnh cũ

                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(files[i]);
                    img.style.width = "120px";
                    img.style.margin = "5px";
                    img.style.border = "1px solid #ddd";
                    img.style.padding = "5px";

                    container.appendChild(img);
                }
                // preview.src = URL.createObjectURL(event.target.files[0]);
            }
        </script>
        <!--**********************************
@endsection
