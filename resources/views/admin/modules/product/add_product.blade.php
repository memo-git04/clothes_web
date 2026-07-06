@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Thêm sản phẩm mới</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- ROW 1 -->
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="product_name"
                                       class="form-control @error('product_name') is-invalid @enderror"
                                       value="{{ old('product_name') }}">

                            </div>

                            <div class="col-md-6">
                                <label>Mô tả</label>
                                <textarea name="description" value="{{old('description')}}" class="form-control"></textarea>
                            </div>
                        </div>

                        <!-- ROW 2 -->
                        <div class="row mt-3">
                            <!-- Replace your empty category div with this -->
                            <div class="col-md-4">
                                <label>Danh mục</label>
                                <div class="category-select-container">
                                    <select name="category_id" id="categorySelect"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                            @if($category->children->count() > 0)
                                                <optgroup label="{{ $category->category_name }}">
                                                    @foreach($category->children as $child)
                                                        <option value="{{ $child->id }}">&nbsp;&nbsp;{{ $child->category_name }}</option>
                                                        @if($child->children->count() > 0)
                                                            @foreach($child->children as $grandChild)
                                                                <option value="{{ $grandChild->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $grandChild->category_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Chất liệu</label>
                                <select name="material_id" class="form-control @error('material_id') is-invalid @enderror">
                                    <option value="">Chọn</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}" {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                            {{ $material->material_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Thương hiệu</label>
                                <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                    <option value="">Chọn</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- VARIANTS -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <label><b>Biến thể (Màu × Kích cỡ)</b></label>

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">

                                        <thead class="bg-light">
                                        <tr>
                                            <th style="min-width:120px">Màu \ Kích cỡ</th>
                                            @foreach($sizes as $size)
                                                <th>{{ $size->size_name }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($colors as $color)

                                            <!-- ROW 1 -->
                                            <tr>
                                                <td rowspan="2" class="align-middle">
                                                    <b>{{ $color->color_name }}</b>
                                                </td>

                                                @foreach($sizes as $size)
                                                    <td>
                                                        <div class="variant-box">

                                                            <!-- checkbox -->
                                                            <input type="checkbox" class="size-check mb-1">

                                                            <!-- stock -->
                                                            <input type="number"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][stock_quantity]"
                                                                   class="form-control mb-1 variant-input"
                                                                   placeholder="Số lượng"
                                                                   disabled>

                                                            <!-- base -->
                                                            <input type="text"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][base_price]"
                                                                   class="form-control mb-1 variant-input money"
                                                                   placeholder="Giá gốc"
                                                                   disabled>

                                                            <!-- sell -->
                                                            <input type="text"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][selling_price]"
                                                                   class="form-control mb-1 variant-input money"
                                                                   placeholder="Giá bán"
                                                                   disabled>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <!-- ROW 2 IMAGE -->
                                            <tr>
                                                <td colspan="{{ count($sizes) }}">
                                                    <div class="image-upload-box">
{{--                                                        @error('color_images')--}}
{{--                                                        <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                                                        @enderror--}}
                                                        <input type="file"
                                                               name="color_images[{{ $color->id }}][]"
                                                               class="form-control image-input "
                                                               multiple>

                                                        <div class="preview mt-2 d-flex flex-wrap"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-4">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                            Thêm mới sản phẩm
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- CSS --}}
    <style>
        .variant-box input {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .image-upload-box {
            padding: 10px;
            border: 1px dashed #ccc;
            background: #fafafa;
        }

        .preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 5px;
            border: 1px solid #ddd;
        }
    </style>
    {{-- JS --}}
    <script>
        document.querySelectorAll('.size-check').forEach(cb => {
            cb.addEventListener('change', function () {
                let box = this.closest('.variant-box');
                let inputs = box.querySelectorAll('.variant-input');

                inputs.forEach(input => {
                    input.disabled = !this.checked;

                    if (!this.checked) input.value = '';
                });
            });
        });

        // format tiền
        document.querySelectorAll('.money').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                this.value = new Intl.NumberFormat('vi-VN').format(value);
            });
        });

        // preview ảnh
        let allFilesMap = new Map();

        document.querySelectorAll('.image-input').forEach((input, index) => {
            allFilesMap.set(index, []);

            input.addEventListener('change', function (e) {
                let files = Array.from(e.target.files);
                let currentFiles = allFilesMap.get(index);

                // thêm file mới vào danh sách cũ
                files.forEach(file => currentFiles.push(file));

                allFilesMap.set(index, currentFiles);

                renderPreview(input, index);
            });
        });

        function renderPreview(input, index) {
            let preview = input.closest('.image-upload-box').querySelector('.preview');
            preview.innerHTML = "";

            let files = allFilesMap.get(index);

            files.forEach((file, i) => {
                let reader = new FileReader();

                reader.onload = function (e) {
                    let div = document.createElement("div");
                    div.style.position = "relative";
                    div.style.marginRight = "5px";

                    div.innerHTML = `
                    <img src="${e.target.result}">
                    <button type="button"
                        onclick="removeImage(${index}, ${i})"
                        style="
                            position:absolute;
                            top:-5px;
                            right:-5px;
                            background:red;
                            color:white;
                            border:none;
                            border-radius:50%;
                            width:20px;
                            height:20px;
                            cursor:pointer;
                        ">×</button>
                `;

                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            });

            updateInputFiles(input, files);
        }

        function removeImage(inputIndex, fileIndex) {
            let files = allFilesMap.get(inputIndex);
            files.splice(fileIndex, 1);

            allFilesMap.set(inputIndex, files);

            let input = document.querySelectorAll('.image-input')[inputIndex];
            renderPreview(input, inputIndex);
        }

        function updateInputFiles(input, files) {
            let dataTransfer = new DataTransfer();

            files.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }
    </script>
@endsection
