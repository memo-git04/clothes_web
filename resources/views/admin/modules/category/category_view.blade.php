<li>
    <!-- Dùng d-flex và justify-content-between để tách làm 2 bên: Tên (trái) - Nút bấm (phải) -->
    <!-- align-items-center để căn giữa theo chiều dọc, mb-2 để tạo khoảng cách giữa các dòng -->
    <div class="d-flex justify-content-between align-items-center mb-2">

        <!-- CỘT TRÁI: Bullet & Tên danh mục -->
        <div class="d-flex align-items-center">
            <!-- Bullet icon thay thế cho checkbox -->
            <i class="fa-solid fa-circle" style="font-size: 6px; color: #6c757d; margin-right: 10px;"></i>
            <span style="font-weight: 500;">{{ $cat->category_name }}</span>
        </div>

        <!-- CỘT PHẢI: Các nút Hành động -->
        <div class="d-flex align-items-center">
            <!-- Nút Sửa -->
            <a href="{{ route('admin.categories.edit', $cat->id) }}"
               class="btn btn-primary btn-sm" title="Chỉnh sửa" style="padding: 2px 8px;">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>

            <!-- Nút Xóa -->
            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                  method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
            @csrf
            @method('DELETE')
            <!-- Thêm ml-1 để cách nút sửa 1 chút -->
                <button type="submit" class="btn btn-danger btn-sm ml-1" title="Xóa"
                        style="padding: 2px 8px;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Đệ quy danh mục con -->
@if($cat->children && $cat->children->count() > 0)
    <!-- Thụt lề 25px cho danh mục con để tạo cấu trúc cây -->
        <ul style="list-style-type: none; padding-left: 25px;">
            @foreach($cat->children as $child)
                @include('admin.modules.category.category_view', ['cat' => $child])
            @endforeach
        </ul>
    @endif
</li>
