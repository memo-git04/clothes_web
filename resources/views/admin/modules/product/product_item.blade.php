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
                            <h4 class="card-title mb-3">Thông tin sản phẩm</h4>

                            <div style="display: flex">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1"><b>Tên sản phẩm: {{ $product->product_name }}</b></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Description: {{ $product->description }}</b> </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Category: {{ $product->category->category_name ?? '' }} </div> </b></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Material: {{ $product->material->name ?? '' }}</b></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1"><b>Brand: {{ $product->brand->brand_name ?? '' }}</b> </label>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-3">Thông tin biến thể sản phẩm</h4>
                            <div style="overflow-x:auto;">
                                <table class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Ảnh</th>
                                        <th>Màu sắc</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Giá nhập</th>
                                        <th>Giá bán</th>
                                        <th>Giá gốc</th>
                                        <th>Act</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product->variants as $variant)
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                        <tr>
                                            <td>{{ $variant->sku }}</td>

                                            <td style="min-width:250px">

                                                <!-- HIỂN THỊ ẢNH CŨ -->
                                                <div style="display:flex; flex-wrap:wrap; gap:5px;">
                                                    @foreach($variant->images as $img)
                                                        <div style="position:relative">
                                                            <img src="{{ asset('storage/'.$img->image_url) }}" width="60">

                                                            <!-- ❌ NÚT XOÁ ẢNH -->
                                                            <form action="{{ route('variant.image.delete', $img->id) }}" method="POST"
                                                                  style="position:absolute; top:0; right:0;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="background:red;color:#fff;border:none;">x</button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- ➕ UPLOAD ẢNH MỚI -->
                                                <input type="file" name="images[]" multiple
                                                       class="form-control mt-1 preview-input">

                                                <!-- 👀 PREVIEW ẢNH MỚI -->
                                                <div class="preview mt-1" style="display:flex; gap:5px; flex-wrap:wrap;"></div>

                                            </td>

                                            <td>{{ $variant->color->color_name ?? '' }}</td>
                                            <td>{{ $variant->size->size_name ?? '' }}</td>

                                                <td> <input type="number" name="stock_quantity" value="{{ $variant->stock_quantity }}" class="form-control" style="width:80px"> </td>
                                            <td>{{ $variant->base_price }}</td>
                                            <td>
                                                <input type="number" name="selling_price" value="{{ $variant->selling_price }}" class="form-control" style="width:80px">
                                            </td>
                                            <td>{{ $variant->original_price }}</td>
                                        </form>
                                        <td>
{{--                                        button delete--}}
                                                <form action="{{ route('variants.destroy', $variant->id) }}" method="POST">
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
                                        <th>SKU</th>
                                        <th>Ảnh</th>
                                        <th>Màu sắc</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Giá nhập </th>
                                        <th>Giá bán</th>
                                        <th>Giá gốc</th>
                                        <th>Act</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div  style="display: flex">
                                <div class="add mt-2 mx-4">
                                    <a href="{{route('products.index')}}"><button type="button" class="btn btn-success"> Back </button></a>
                                </div>
                                <div class="add mt-2 mx-4">
                                    <a href="{{route('products.edit', $product->id) }}"><button type="button" class="btn btn-primary"> Update </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

<script>
    document.querySelectorAll('.preview-input').forEach(input => {
        input.addEventListener('change', function(e){
            let preview = this.closest('td').querySelector('.preview');
            preview.innerHTML = "";

            Array.from(e.target.files).forEach(file => {
                let reader = new FileReader();

                reader.onload = function(e){
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '60px';
                    preview.appendChild(img);
                }

                reader.readAsDataURL(file);
            });
        });
    });
</script>
