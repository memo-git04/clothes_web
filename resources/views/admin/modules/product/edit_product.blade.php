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

                                <form class="form-valide" action="{{route('products.update', $product->id )}}" method="post"
                                      enctype="multipart/form-data" style="display: flex">
                                    @csrf
                                    @method('PUT')
                                    {{--                                    LEFT--}}
                                    <div class="col-sm-5">

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1"><b>Product Name</b></label>
                                            <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Category</b></label>
                                            <select name="category_id" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Material</b></label>
                                            <select name="material_id" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        {{ $product->material_id == $material->id ? 'selected' : '' }}>
                                                        {{ $material->material_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1"><b>Brand</b></label>
                                            <select name="brand_id" class="form-control">
                                                <option value="">Please select option</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
{{--                                        VARIANT PRODUCT--}}
                                        @foreach($product->variants as $index => $variant)
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1"><b>Color</b></label>
                                                <input type="text" name="product_name" readonly value="{{ $variant->color->color_name }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1"><b>Size</b></label>
                                                <select name="variants[{{ $index }}][size_id]" class="form-control">
                                                    @foreach($sizes as $size)
                                                        <option value="{{ $size->id }}"
                                                            {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                            {{ $size->size_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1"><b>SKU</b></label>
                                                <input type="text" name="sku" readonly value="{{ $variant->sku }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                    </div>

                                    {{--                                    RIGHT--}}
                                    <div class="col-sm-7">
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1"><b>Description </b></label>
                                                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$product->description}}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlInput1"><b>Base Price</b></label>
                                                <input type="text" name="variants[{{ $index }}][base_price]" value="{{ $variant->base_price }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1"><b>Selling Price</b></label>
                                                <input type="text" name="variants[{{ $index }}][selling_price]" value="{{ $variant->selling_price }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1"><b>Origin Price</b></label>
                                                <input type="text" name="variants[{{ $index }}][original_price]"  value="{{ $variant->original_price }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1"><b>Stock quantity</b></label>
                                                <input type="text" name="variants[{{ $index }}][stock_quantity]"  value="{{ $variant->stock_quantity }}" class="form-control" id="exampleFormControlInput1">
                                            </div>
{{--                                        ID variant--}}
                                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
{{--                                            IMAGE OLD--}}
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1"><b>Old Images</b></label>
                                                <div id="preview-container-{{ $index }}">
                                                    @foreach($variant->images as $img)
                                                        <div style="display:inline-block; position:relative">
                                                            <img src="{{ asset('storage/'.$img->image_url) }}"
                                                                 width="100" style="margin:5px">

                                                            <input type="checkbox"
                                                                   name="variants[{{ $index }}][delete_images][]"
                                                                   value="{{ $img->id }}"> Delete
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{-- IMAGE NEW --}}
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">
                                                    <b>New Images (if you want to add more images, please select new images)</b>
                                                </label>
                                                <input type="file" name="variants[{{ $index }}][images][]" multiple onchange="previewNewImages(event)">
                                                <br>
                                                <div id="preview-container">
                                                    <img id="preview" style="margin-top:20px;">
                                                </div>
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
            function previewImages(event, index) {
                const container = document.getElementById('preview-container-' + index);

                const files = event.target.files;

                for (let i = 0; i < files.length; i++) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(files[i]);
                    img.style.width = "100px";
                    img.style.margin = "5px";
                    img.style.border = "1px solid #ddd";

                    container.appendChild(img);
                }
            }
            function previewNewImages(event) {
                const container = document.getElementById('preview-container');

                const files = event.target.files;

                for (let i = 0; i < files.length; i++) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(files[i]);
                    img.style.width = "100px";
                    img.style.margin = "5px";
                    img.style.border = "1px solid #ddd";

                    container.appendChild(img);
                }
            }
        </script>
        <!--**********************************
@endsection
