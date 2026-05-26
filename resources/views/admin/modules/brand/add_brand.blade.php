@extends('admin.layouts.dashboard')

@section('content')

    <div class="content-body">

        <!-- Breadcrumb -->
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="#">Home</a></li>
                </ol>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add New Product</h4>

                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <!-- LEFT -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label><b>Product Name</b></label>
                                            <input type="text" name="product_name" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Category</b></label>
                                            <select name="category_id" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><b>Brand</b></label>
                                            <select name="brand_id" class="form-control">
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}">
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><b>Material</b></label>
                                            <select name="material_id" class="form-control">
                                                @foreach($materials as $material)
                                                    <option value="{{ $material->id }}">
                                                        {{ $material->material_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><b>Description</b></label>
                                            <textarea name="description" class="form-control"></textarea>
                                        </div>

                                    </div>

                                    <!-- RIGHT -->
                                    <div class="col-md-6">

                                        <h5>Variant</h5>

                                        <div class="form-group">
                                            <label><b>Color</b></label>
                                            <select name="variants[0][color_id]" class="form-control">
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}">
                                                        {{ $color->color_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><b>Size</b></label>
                                            <select name="variants[0][size_id]" class="form-control">
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}">
                                                        {{ $size->size_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label><b>SKU</b></label>
                                            <input type="text" name="variants[0][sku]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Stock</b></label>
                                            <input type="number" name="variants[0][stock_quantity]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Base Price</b></label>
                                            <input type="text" name="variants[0][base_price]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Selling Price</b></label>
                                            <input type="text" name="variants[0][selling_price]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Original Price</b></label>
                                            <input type="text" name="variants[0][original_price]" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label><b>Images</b></label>
                                            <input type="file" name="variants[0][images][]" multiple class="form-control">
                                        </div>

                                    </div>

                                </div>

                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Add Product
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
