@extends('admin.layouts.dashboard')
@section('content')

    <div class="content-body">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Add new product</h4>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- ROW 1 --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                        </div>

                        {{-- ROW 2 --}}
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Material</label>
                                <select name="material_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Brand</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- VARIANTS --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <label><b>Variants (Color × Size)</b></label>

                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">

                                        <thead class="bg-light">
                                        <tr>
                                            <th style="min-width:120px">Color \ Size</th>
                                            @foreach($sizes as $size)
                                                <th>{{ $size->size_name }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($colors as $color)

                                            {{-- ROW 1 --}}
                                            <tr>
                                                <td rowspan="2" class="align-middle">
                                                    <b>{{ $color->color_name }}</b>
                                                </td>

                                                @foreach($sizes as $size)
                                                    <td>
                                                        <div class="variant-box">

                                                            {{-- checkbox --}}
                                                            <input type="checkbox" class="size-check mb-1">

                                                            {{-- stock --}}
                                                            <input type="number"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][stock_quantity]"
                                                                   class="form-control mb-1 variant-input"
                                                                   placeholder="Stock"
                                                                   disabled>

                                                            {{-- base --}}
                                                            <input type="text"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][base_price]"
                                                                   class="form-control mb-1 variant-input money"
                                                                   placeholder="Base price"
                                                                   disabled>

                                                            {{-- sell --}}
                                                            <input type="text"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][selling_price]"
                                                                   class="form-control mb-1 variant-input money"
                                                                   placeholder="Sell price"
                                                                   disabled>

                                                            {{-- origin --}}
                                                            <input type="text"
                                                                   name="variants[{{ $color->id }}][{{ $size->id }}][original_price]"
                                                                   class="form-control variant-input money"
                                                                   placeholder="Origin price"
                                                                   disabled>

                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>

                                            {{-- ROW 2 IMAGE --}}
                                            <tr>
                                                <td colspan="{{ count($sizes) }}">
                                                    <div class="image-upload-box">

                                                        <input type="file"
                                                               name="color_images[{{ $color->id }}][]"
                                                               class="form-control image-input"
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

                        <button class="btn btn-primary mt-4">Create Product</button>

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

        // enable/disable input
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
