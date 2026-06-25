<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parents', 'children')
            ->orderBy('order')
            ->orderBy('level')
            ->orderBy('category_name')
            ->get();
        return view('admin.modules.category.index_category', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categoryTreeHtml = $this->buildCategoryTreeCheckbox();
        return view('admin.modules.category.add_category',[
            'categoryTreeHtml' => $categoryTreeHtml
        ]);
    }
    private function buildCategoryTreeCheckbox($level = 0)
    {
        $html = '';
        // Lấy root categories (không có cha)
        $roots = Category::whereDoesntHave('parents')
            ->with('children')
            ->orderBy('order')
            ->orderBy('category_name')
            ->get();

        foreach ($roots as $root) {
            $html .= $this->renderCategoryNode($root, $level);
        }

        return $html;
    }

    private function renderCategoryNode($category, $level = 0)
    {
        $html = '<div class="form-check ms-' . ($level * 6) . ' mb-2">';

        $html .= '<input class="form-check-input" type="checkbox"
                     name="parent_ids[]"
                     id="cat_' . $category->id . '"
                     value="' . $category->id . '">';

        $html .= '<label class="form-check-label" for="cat_' . $category->id . '">';
        $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        if ($level > 0) $html .= '└─ ';
        $html .= $category->category_name . ' <small class="text-muted">(L' . $category->level . ')</small>';
        $html .= '</label>';
        $html .= '</div>';

        // Đệ quy con
        foreach ($category->children as $child) {
            $html .= $this->renderCategoryNode($child, $level + 1);
        }

        return $html;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $parentIds = $request->parent_ids ?? [];
        $parentIds = array_filter($parentIds);           // Loại bỏ rỗng
        $parentIds = array_unique($parentIds);           // Loại bỏ trùng lặp
        $isRoot = empty($parentIds);

        $category = Category::create([
            'category_name' => $request->category_name,
            'description'   => $request->description,
            'order'         => $request->order ?? 0,
            'is_root'       => $isRoot,
            'level'         => 1,
        ]);

        if (!$isRoot && count($parentIds) > 0) {
            $category->parents()->attach($parentIds);

            // Tính level
            $maxLevel = Category::whereIn('id', $parentIds)->max('level') ?? 0;
            $category->update(['level' => $maxLevel + 1]);
        }
        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    private function buildCategoryTreeCheckboxForEdit($currentCategory, $level = 0)
    {
        $html = '';
        $roots = Category::whereDoesntHave('parents')
            ->with('children')
            ->orderBy('order')
            ->orderBy('category_name')
            ->get();

        foreach ($roots as $root) {
            $html .= $this->renderCategoryNodeForEdit($root, $currentCategory, $level);
        }

        return $html;
    }

    private function renderCategoryNodeForEdit($category, $currentCategory, $level = 0)
    {
        if ($category->id === $currentCategory->id) return ''; // Không hiển thị chính nó

        $isChecked = $currentCategory->parents->pluck('id')->contains($category->id);

        $html = '<div class="form-check ms-' . ($level * 6) . ' mb-2">';

        $html .= '<input class="form-check-input" type="checkbox"
                     name="parent_ids[]"
                     id="cat_' . $category->id . '"
                     value="' . $category->id . '" ' . ($isChecked ? 'checked' : '') . '>';

        $html .= '<label class="form-check-label" for="cat_' . $category->id . '">';
        $html .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        if ($level > 0) $html .= '└─ ';
        $html .= $category->category_name . ' <small class="text-muted">(L' . $category->level . ')</small>';
        $html .= '</label>';
        $html .= '</div>';

        foreach ($category->children as $child) {
            $html .= $this->renderCategoryNodeForEdit($child, $currentCategory, $level + 1);
        }

        return $html;
    }
    public function edit(Category $category)
    {


        $categoryTreeHtml = $this->buildCategoryTreeCheckboxForEdit($category);

        return view('admin.modules.category.edit_category', [
            'category' => $category,
            'categoryTreeHtml' => $categoryTreeHtml,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $parentIds = $request->parent_ids ?? [];
        $parentIds = array_filter($parentIds);
        $parentIds = array_unique($parentIds);
        $isRoot = empty($parentIds);

        $category->update([
            'category_name' => $request->category_name,
            'description'   => $request->description,
            'order'         => $request->order ?? $category->order,
            'is_root'       => $isRoot,
        ]);

        // Sync danh mục cha
        $category->parents()->sync($parentIds);

        // Cập nhật lại level
        if (!$isRoot && count($parentIds) > 0) {
            $maxLevel = Category::whereIn('id', $parentIds)->max('level') ?? 0;
            $category->update(['level' => $maxLevel + 1]);
        } else {
            $category->update(['level' => 1]);
        }

        return redirect()->back()
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem danh mục có sản phẩm không
        if ($category->products()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì đang có sản phẩm liên kết!');
        }

        // Kiểm tra có danh mục con không
        if ($category->children()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì đang có danh mục con!');
        }

        // Xóa quan hệ
        $category->parents()->detach();
        $category->children()->detach();

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
