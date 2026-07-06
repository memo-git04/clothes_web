<ul style="list-style-type: none; padding-left: 20px;">
    <li>
        @if($cat->id != $currentCategoryId)
            @php
                // Tính level mới nếu chọn danh mục này làm cha: Level cha + 1
                $potentialLevel = $cat->level + 1;
                // Kiểm tra xem danh mục đang edit có con hay không, nếu có con thì level của con sẽ là potentialLevel + 1
                $maxChildLevel = $currentCategory->children->max('level') ?? $potentialLevel;
                $futureChildLevel = $maxChildLevel + 1;

                // Nếu Level mới > 3 HOẶC Con của nó sẽ bị đẩy lên > 3 thì disable checkbox
                $isDisabled = ($potentialLevel > 3 || ($potentialLevel == 2 && $futureChildLevel > 3)) ? 'disabled' : '';
            @endphp

            <div class="checkbox">
                <label @if($isDisabled) class="text-muted" style="cursor: not-allowed;" @endif>
                    <input type="checkbox"
                           name="parent_ids[]"
                           value="{{ $cat->id }}"
                           class="parent-checkbox"
                        {{ in_array($cat->id, $selectedParentIds) ? 'checked' : '' }}
                        {{ $isDisabled }}>
                    {{ $cat->category_name }}
                    @if($isDisabled)
                        <small class="text-danger">(Vượt 3 cấp)</small>
                    @endif
                </label>
            </div>
        @else
            <div class="form-text">
                {{ $cat->category_name }} <span class="text-muted">(Đang chỉnh sửa)</span>
            </div>
        @endif

        @php
            $children = $cat->children;
        @endphp

        @if($children->count() > 0)
            <ul style="list-style-type: none; padding-left: 20px;">
                @foreach($children as $child)
                    @include('admin.modules.category.edit_category_row', [
                        'cat' => $child,
                        'currentCategoryId' => $currentCategoryId,
                        'selectedParentIds' => $selectedParentIds,
                        'currentCategory' => $currentCategory // Truyền thêm biến này từ View cha
                    ])
                @endforeach
            </ul>
        @endif
    </li>
</ul>
