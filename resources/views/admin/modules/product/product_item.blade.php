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
                            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <h4 class="card-title">Thông tin sản phẩm</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="200">Tên sản phẩm</th>
                                                <td>
                                                    <input type="text" name="product_name"
                                                           value="{{ $product->product_name }}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mô tả</th>
                                                <td>
                                                    <textarea name="description" class="form-control">
                                                        {{ $product->description }}
                                                    </textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Danh mục</th>
                                                <td>{{ $product->category->category_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Brand</th>
                                                <td>{{ $product->brand->brand_name ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Chất liệu</th>
                                                <td>{{ $product->material->material_name ?? '' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mt-3">Thông tin biến thể sản phẩm</h4>
                                    </div>
                                    <div class="card-body">
                                        @foreach($product->variants as $variant)
                                            <div class="border p-3 mb-3">

                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="200">SKU</th>
                                                        <td>{{ $variant->sku }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Màu</th>
                                                        <td>{{ $variant->color->color_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Size</th>
                                                        <td>{{ $variant->size->size_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Số lượng</th>
                                                        <td>
                                                            <input type="number"
                                                                   name="variants[{{ $variant->id }}][stock_quantity]"
                                                                   value="{{ $variant->stock_quantity }}"
                                                                   class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá nhập</th>
                                                        <td>
                                                            <input type="text"
                                                                   name="variants[{{ $variant->id }}][base_price]"
                                                                   value="{{number_format(optional($variant)->base_price ?? 0, 0, ',', '.') }}"
                                                                   class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá bán</th>
                                                        <td>
                                                            <input type="text"
                                                                   name="variants[{{ $variant->id }}][selling_price]"
                                                                   value="{{  number_format(optional($variant)->selling_price ?? 0, 0, ',', '.') }}"
                                                                   class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá gốc</th>
                                                        <td>
                                                            <input type="text"
                                                                   name="variants[{{ $variant->id }}][original_price]"
                                                                   value="{{  number_format(optional($variant)->original_price ?? 0, 0, ',', '.') }}"
                                                                   class="form-control">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Ảnh</th>
                                                        <td>
                                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                                @foreach($variant->images as $img)
                                                                    <div class="image-item position-relative">
                                                                        <img src="{{ asset('storage/'.$img->image_url) }}" width="80" class="rounded border">

                                                                        {{-- nút X --}}
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-sm btn-remove-image"
                                                                                data-id="{{ $img->id }}">
                                                                            ×
                                                                        </button>

                                                                        {{-- hidden để submit --}}
                                                                        <input type="hidden"
                                                                               name="variants[{{ $variant->id }}][delete_images][]"
                                                                               value=""
                                                                               class="delete-image-input"
                                                                               data-id="{{ $img->id }}">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            {{-- PREVIEW ẢNH MỚI --}}
                                                            <div class="preview d-flex flex-wrap gap-2 mb-2"></div>

                                                            {{-- INPUT --}}
                                                            <input type="file"
                                                                   name="variants[{{ $variant->id }}][images][]"
                                                                   multiple
                                                                   class="form-control preview-input">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Xoá biến thể</th>
                                                        <td>

                                                            <button type="button"
                                                                    class="btn btn-danger btn-delete-variant"
                                                                    data-url="{{ route('variants.destroy', $variant->id) }}">
                                                                Delete Variant
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div  style="display: flex">
                                    <div class="add mt-2 mx-4">
                                        <a href="{{route('products.index')}}"><button type="button" class="btn btn-success"> Back </button></a>
                                    </div>
                                    <div class="add mt-2 mx-4">
                                        <button type="submit" class="btn btn-primary"> Update </button>
                                    </div>
                                    <div class="add mt-2 mx-4">
                                        <a href="" class="btn btn-success">
                                            + Thêm variant
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form id="delete-variant-form" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.btn-delete-variant').forEach(btn => {

                btn.addEventListener('click', function () {

                    let url = this.dataset.url;

                    if (confirm('Bạn có chắc muốn xoá biến thể này không?')) {

                        let form = document.getElementById('delete-variant-form');

                        form.action = url;

                        form.submit();
                    }
                });

            });

        });

        document.addEventListener('DOMContentLoaded', function () {

            // =========================
            // 🟢 PREVIEW + XOÁ ẢNH MỚI
            // =========================
            document.querySelectorAll('.preview-input').forEach(input => {

                input.addEventListener('change', function (e) {

                    let preview = this.closest('td').querySelector('.preview');
                    preview.innerHTML = "";

                    let files = Array.from(this.files);

                    files.forEach((file, index) => {

                        let reader = new FileReader();

                        reader.onload = function (e) {

                            let div = document.createElement('div');
                            div.classList.add('image-item');
                            div.style.position = 'relative';
                            div.dataset.index = index;

                            let img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '80px';

                            // 🔴 NÚT X
                            let btn = document.createElement('button');
                            btn.innerHTML = '×';
                            btn.type = 'button';
                            btn.classList.add('btn','btn-danger','btn-sm');
                            btn.style.position = 'absolute';
                            btn.style.top = '0';
                            btn.style.right = '0';

                            btn.addEventListener('click', function () {

                                div.remove();

                                let dt = new DataTransfer();

                                let currentFiles = Array.from(input.files);

                                currentFiles.forEach((f, i) => {
                                    if (i !== index) {
                                        dt.items.add(f);
                                    }
                                });

                                input.files = dt.files;
                            });

                            div.appendChild(img);
                            div.appendChild(btn);
                            preview.appendChild(div);
                        };

                        reader.readAsDataURL(file);
                    });

                });
            });


            // =========================
            // 🔴 XOÁ ẢNH CŨ (DB)
            // =========================
            document.querySelectorAll('.btn-remove-image').forEach(btn => {

                btn.addEventListener('click', function () {

                    let container = this.closest('.image-item');

                    let input = container.querySelector('.delete-image-input');

                    if (input) {
                        input.value = this.dataset.id;
                    }

                    // ẩn UI
                    container.style.display = 'none';
                });

            });

        });
    </script>
@endsection
