@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chỉnh sửa danh mục</h4>
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            @endif
                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Tên danh mục <span class="text-danger">*</span></label>
                                    <div class="col-lg-7">
                                        <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name', $category->category_name) }}">
                                        @error('category_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Mô tả</label>
                                    <div class="col-lg-7">
                                        <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Danh mục cha</label>
                                    <div class="col-lg-7 nested-checkboxes" style=" overflow-y: auto; border: 1px solid #ced4da; padding: 15px; border-radius: 5px; background: #f8f9fa;">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="parent_ids[]" value="" class="root-checkbox" {{ in_array('', $selectedParentIds) ? 'checked' : '' }}>
                                                <strong>Không có (Danh mục gốc)</strong>
                                            </label>
                                        </div>
                                        <hr class="mt-1 mb-2">

                                        @foreach($rootCategories as $rootCat)
                                            @include('admin.modules.category.edit_category_row', [
                                                'cat' => $rootCat,
                                                'currentCategoryId' => $category->id,
                                                'selectedParentIds' => $selectedParentIds,
                                                'currentCategory' => $category // <--- THÊM DÒNG NÀY ĐỂ TRUYỀN BIẾN
                                            ])
                                        @endforeach

                                        @error('parent_ids')
                                        <span class="text-danger d-block mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // 1. Check/Uncheck Cha -> Tất cả các Con theo trạng thái đó
            $('.nested-checkboxes').on('change', 'input.parent-checkbox', function() {
                var isChecked = $(this).prop('checked');
                $(this).closest('li').find('ul input[type="checkbox"]').prop('checked', isChecked);
            });

            // 2. Check/Uncheck Con -> Cập nhật trạng thái Cha
            $('.nested-checkboxes').on('change', 'ul input[type="checkbox"]', function() {
                var parentLi = $(this).closest('ul').parent('li');
                var parentCheckbox = parentLi.find('> .checkbox input.parent-checkbox');
                var siblingCheckboxes = $(this).closest('ul').find('> li > .checkbox input[type="checkbox"]');

                var allChecked = true;
                siblingCheckboxes.each(function() {
                    if (!$(this).prop('checked')) allChecked = false;
                });

                parentCheckbox.prop('checked', allChecked);
            });

            // 3. Nếu check vào "Không có (Root)" -> Bỏ hết các checkbox khác
            $('.root-checkbox').on('change', function() {
                if ($(this).prop('checked')) {
                    $('.nested-checkboxes input.parent-checkbox').prop('checked', false);
                }
            });

            // 4. Nếu check vào bất kỳ Cha/Con nào -> Bỏ check ô "Không có (Root)"
            $('.nested-checkboxes').on('change', 'input.parent-checkbox', function() {
                if ($(this).prop('checked')) {
                    $('.root-checkbox').prop('checked', false);
                }
            });
        });
    </script>
@endsection
