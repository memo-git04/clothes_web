@extends('admin.dashboard')
@section('content')
<div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body ">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <h4 class="card-title">Thông tin sản phẩm</h4>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="200">Tên sản phẩm</th>
                                                <td>
                                                    <input type="text" name="product_name"
                                                           value="{{ old('product_name', $product->product_name) }}"
                                                           class="form-control @error('product_name') is-invalid @enderror">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Mô tả</th>
                                                <td>
                                                    <textarea name="description"
                                                              class="form-control @error('description') is-invalid @enderror">
                                                        {{ old('description', $product->description) }}
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
                                    <div class="card-body" id="variants-container">
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
                                                                   value="{{ old('variants.' . $variant->id . '.stock_quantity', $variant->stock_quantity) }}"
                                                                   class="form-control @error('variants.' . $variant->id . '.stock_quantity') is-invalid @enderror">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá gốc</th>
                                                        <td>
                                                            <input type="text"
                                                                   name="variants[{{ $variant->id }}][base_price]"
                                                                   value="{{ old('variants.' . $variant->id . '.base_price', number_format($variant->base_price ?? 0, 0, ',', '.')) }}"
                                                                   class="form-control price-format @error('variants.' . $variant->id . '.base_price') is-invalid @enderror">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Giá bán</th>
                                                        <td>
                                                            <input type="text"
                                                                   name="variants[{{ $variant->id }}][selling_price]"
                                                                   value="{{ old('variants.' . $variant->id . '.selling_price', number_format($variant->selling_price ?? 0, 0, ',', '.')) }}"
                                                                   class="form-control price-format @error('variants.' . $variant->id . '.selling_price') is-invalid @enderror">
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
                                                                    data-id="{{ $variant->id }}"
                                                                    data-url="{{ route('admin.products.variants.destroy', $variant->id) }}">
                                                                Xóa biến thể
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
                                        <a href="{{route('admin.products.index')}}"><button type="button" class="btn btn-success"> Quay trở lại </button></a>
                                    </div>
                                    <div class="add mt-2 mx-4">
                                        <button type="submit" class="btn btn-primary"> Cập nhật </button>
                                    </div>
                                    <div class="add mt-2 mx-4">
                                        <button type="button" id="btn-add-variant" class="btn btn-success">
                                            + Thêm variant
                                        </button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {

            let variantIndex = Date.now();

            const variantTemplate = $('#variant-template').html();

            // ==================== THÊM VARIANT MỚI ====================
            $('#btn-add-variant').on('click', function() {
                let newVariantHTML = variantTemplate.replace(/new_variants\[\d+\]/g, 'new_variants[' + variantIndex + ']');
                $('#variants-container').append(newVariantHTML);
                variantIndex++;
                initPreviewForNewVariant();
            });

            // ==================== XÓA VARIANT (CŨ + MỚI) ====================
            $(document).on('click', '.btn-delete-variant, .btn-remove-variant', function(e) {
                e.preventDefault();

                let btn = $(this);
                let isNewVariant = btn.hasClass('btn-remove-variant');

                if (!confirm('Bạn có chắc chắn muốn xóa biến thể này?')) return;

                if (isNewVariant) {
                    // Xóa variant mới (chưa lưu)
                    btn.closest('.border.p-3.mb-3').fadeOut(300, function() {
                        $(this).remove();
                    });
                    return;
                }

                // Xóa variant cũ (đã có trong DB) - AJAX
                let url = btn.data('url');
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') || $('#delete-variant-form input[name="_token"]').val()
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.closest('.border.p-3.mb-3').fadeOut(300, function() {
                                $(this).remove();
                            });
                            toastr.success(response.message || 'Đã xóa biến thể thành công');
                        }
                    },
                    error: function(xhr) {
                        let message = xhr.responseJSON?.message || 'Có lỗi xảy ra khi xóa biến thể';
                        toastr.error(message);
                    }
                });
            });

            // ==================== PREVIEW ẢNH ====================
            function initPreviewForNewVariant() {
                $('.preview-input').off('change').on('change', function() {
                    let previewContainer = $(this).closest('td').find('.preview');
                    previewContainer.empty();

                    let files = this.files;
                    for (let i = 0; i < files.length; i++) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            let divHTML = `
                        <div class="image-item position-relative d-inline-block me-2" style="margin-bottom:8px;">
                            <img src="${e.target.result}" width="80" class="rounded border">
                            <button type="button" class="btn btn-danger btn-sm remove-preview-btn"
                                    style="position:absolute; top:-6px; right:-6px; width:20px; height:20px; padding:0;">×</button>
                        </div>`;
                            previewContainer.append(divHTML);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                });
            }

            // Xóa preview ảnh
            $(document).on('click', '.remove-preview-btn', function() {
                $(this).closest('.image-item').remove();
            });

            // Xóa ảnh cũ (đánh dấu xóa)
            $(document).on('click', '.btn-remove-image', function() {
                let imageItem = $(this).closest('.image-item');
                let imageId = imageItem.find('.delete-image-input').data('id');
                imageItem.find('.delete-image-input').val(imageId);
                imageItem.fadeOut();
            });

            // Khởi tạo ban đầu
            initPreviewForNewVariant();
        });
    </script>
    <!-- Template cho variant mới -->
    <template id="variant-template">
        <div class="border p-3 mb-3 new-variant">
            <table class="table table-bordered">
                <tr>
                    <th>Màu</th>
                    <td>
                        <select name="new_variants[NEW_INDEX][color_id]" class="form-control" required>
                            @foreach(\App\Models\Color::all() as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td>
                        <select name="new_variants[NEW_INDEX][size_id]" class="form-control" required>
                            @foreach(\App\Models\Size::all() as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Số lượng</th>
                    <td><input type="number" name="new_variants[NEW_INDEX][stock_quantity]" value="0" min="0" class="form-control"></td>
                </tr>
                <tr>
                    <th>Giá nhập</th>
                    <td><input type="text" name="new_variants[NEW_INDEX][base_price]" class="form-control price-format" value="0"></td>
                </tr>
                <tr>
                    <th>Giá bán</th>
                    <td><input type="text" name="new_variants[NEW_INDEX][selling_price]" class="form-control price-format" value="0"></td>
                </tr>
                <tr>
                    <th>Ảnh</th>
                    <td>
                        <div class="preview d-flex flex-wrap gap-2 mb-2"></div>
                        <input type="file" name="new_variants[NEW_INDEX][images][]" multiple class="form-control preview-input">
                    </td>
                </tr>
                <tr>
                    <th>Hành động</th>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove-variant">Xóa biến thể này</button>
                    </td>
                </tr>
            </table>
        </div>
    </template>

@endsection
