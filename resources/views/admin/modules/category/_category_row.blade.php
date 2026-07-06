<ul style="list-style-type: none; padding-left: 20px;">
    <li>
        <div class="checkbox">
            <label>
                <input type="checkbox"
                       name="parent_ids[]"
                       value="{{ $cat->id }}"
                       class="parent-checkbox"
                    {{ in_array($cat->id, $selectedParentIds) ? 'checked' : '' }}
                    {{ $currentCategoryId == $cat->id ? 'disabled' : '' }}>
                {{ $cat->category_name }}
            </label>
        </div>

        @php
            // Get children of this category
            $children = $cat->children;
        @endphp

        @if($children->count() > 0)
            <ul style="list-style-type: none; padding-left: 20px;">
                @foreach($children as $child)
                    @include('admin.modules.category._category_row', [
                        'cat' => $child,
                        'currentCategoryId' => $currentCategoryId ?? null,
                        'selectedParentIds' => $selectedParentIds
                    ])
                @endforeach
            </ul>
        @endif
    </li>
</ul>
