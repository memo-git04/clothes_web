@extends('admin.dashboard')
@section('content')
    <div class="content-body">
        <!-- ... Breadcrumb ... -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thêm mới danh mục</h4>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf

                            <!-- Tên danh mục -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Tên danh mục <span class="text-danger">*</span></label>
                                    <div class="col-lg-7">
                                        <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name') }}">
                                        @error('category_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Mô tả -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Mô tả</label>
                                    <div class="col-lg-7">
                                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <!-- Danh mục cha -->
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Danh mục cha</label>
                                    <div class="col-lg-7 nested-checkboxes" style="max-height: 300px; overflow-y: auto; border: 1px solid #ced4da; padding: 15px; border-radius: 5px; background: #f8f9fa;">

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="parent_ids[]" value="" class="root-checkbox" {{ in_array('', old('parent_ids', [])) ? 'checked' : '' }}>
                                                <strong>Không có (Danh mục gốc)</strong>
                                            </label>
                                        </div>
                                        <hr class="mt-1 mb-2">

                                        @foreach($rootCategories as $rootCat)
                                            @include('admin.modules.category._category_row', [
                                                'cat' => $rootCat,
                                                'currentCategoryId' => null,
                                                'selectedParentIds' => old('parent_ids', [])
                                            ])
                                        @endforeach

                                        @error('parent_ids')
                                        <span class="text-danger d-block mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Nút bấm -->
                                <div class="form-group row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Thêm mới</button>
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
