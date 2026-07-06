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
        $rootCategories = Category::with('children.children.children')
            ->whereNull('parent_id') // Adjust this condition based on your DB setup (e.g., where('parent_id', 0))
            ->orderBy('id', 'ASC')
            ->get();
        return view('admin.modules.category.index_category', [
            'rootCategories' => $rootCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rootCategories = Category::whereNull('parent_id')
            ->with('children.children') // This loads grandchildren
            ->get();
        return view('admin.modules.category.add_category', [
            'rootCategories' => $rootCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $parentIds = $request->input('parent_ids', []);
        $parentIds = array_filter($parentIds, function ($value) {
            return $value !== '';
        });

        $data = $request->only(['category_name', 'description']);
        //th1: nếu là danh mục gốc
        if (empty($parentIds)) {
            $data['is_root'] = 1;
            $data['parent_id'] = null;
            $data['level'] = 0;

            Category::create($data);
            //th2: nếu là danh mục con, chon 1 hoac nhieu cha
        } else {
            $maxParentLevel = Category::whereIn('id', $parentIds)->max('level');
            $level = $maxParentLevel + 1;

            if ($level > 3) {
                return redirect()->back()
                    ->withErrors(['parent_id' => 'Danh mục con chỉ được phép có tối đa 3 cấp.'])
                    ->withInput();
            }

            $data['is_root'] = 0;
            $data['level'] = $level;
            //lap qua tung parent_id de tao danh muc con
            foreach ($parentIds as $parentId) {
                $data['parent_id'] = $parentId;
                Category::create($data);
            }
        }
        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm mới danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $rootCategories = Category::where('is_root', 1)
            ->with('children.children')
            ->get();

        // Chỉ lấy ID của cha trực tiếp của danh mục đang edit
        $selectedParentIds = $category->parent_id ? [$category->parent_id] : [];

        return view('admin.modules.category.edit_category', [
            'category' => $category,
            'rootCategories' => $rootCategories,
            'selectedParentIds' => $selectedParentIds // Chỉ truyền 1 ID duy nhất hoặc rỗng
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $parentIds = $request->input('parent_ids', []);
        $parentIds = array_filter($parentIds, function($value) {
            return $value !== '';
        });

        $data = $request->only('category_name', 'description');

        if (!empty($parentIds)) {
            // Sắp xếp các cha được chọn theo level giảm dần (cha sâu nhất lên đầu)
            $selectedParents = Category::whereIn('id', $parentIds)->orderBy('level', 'desc')->get();

            // 1. Lấy cha chính (cha có level sâu nhất) để UPDATE bản ghi hiện tại
            $directParent = $selectedParents->first();
            $newParentId = $directParent->id;
            $newLevel = $directParent->level + 1;

            // Tính level tương lai của con cháu
            $maxChildLevel = $category->children->max('level') ?? $newLevel;
            $futureChildLevel = $maxChildLevel - $category->level + $newLevel + 1;

            // Quy tắc: Cấp 3 muốn làm cha -> Cấm
            if ($newLevel >= 3 && $category->children()->count() > 0) {
                return back()->withInput()->withErrors(['parent_ids' => 'Danh mục cấp 3 không thể làm cha!']);
            }

            // Kiểm tra vượt 3 cấp
            if ($newLevel > 3 || $futureChildLevel > 3) {
                return back()->withInput()->withErrors(['parent_ids' => 'Hành động này khiến cấu trúc vượt quá 3 cấp độ!']);
            }

            // Check trùng tên cục bộ cho cha chính
            $duplicateQuery = Category::where('parent_id', $newParentId)
                ->where('category_name', $data['category_name']);
            if ($category->parent_id == $newParentId && $category->category_name == $data['category_name']) {
                $duplicateQuery->where('id', '!=', $category->id);
            }
            if ($duplicateQuery->exists()) {
                return back()->withInput()->withErrors(['category_name' => 'Trong cùng một danh mục cha, không thể có 2 danh mục con trùng tên!']);
            }

            // CẬP NHẬT DANH MỤC HIỆN TẠI
            $category->update([
                'category_name' => $data['category_name'],
                'description' => $data['description'] ?? $category->description,
                'parent_id' => $newParentId,
                'is_root' => 0,
                'level' => $newLevel
            ]);
            $this->updateChildrenRecursively($category);

            // 2. XỬ LÝ CÁC CHA CÒN LẠI: TẠO MỚI BẢN GHI (REPLICATE)
            $otherParents = $selectedParents->skip(1); // Bỏ qua thằng đầu tiên đã xử lý
            foreach ($otherParents as $otherParent) {
                $otherParentId = $otherParent->id;
                $otherNewLevel = $otherParent->level + 1;

                // Check vượt 3 cấp cho nhánh mới
                $otherFutureChildLevel = $maxChildLevel - $category->level + $otherNewLevel + 1;
                if ($otherNewLevel > 3 || $otherFutureChildLevel > 3) {
                    return back()->withInput()->withErrors(['parent_ids' => 'Hành động này khiến cấu trúc vượt quá 3 cấp độ ở một nhánh khác!']);
                }

                // Check trùng tên cục bộ cho nhánh mới
                if (Category::where('parent_id', $otherParentId)->where('category_name', $data['category_name'])->exists()) {
                    return back()->withInput()->withErrors(['category_name' => 'Trong cùng một danh mục cha, không thể có 2 danh mục con trùng tên!']);
                }

                // Nhân bản bản ghi hiện tại (Replicate)
                $newCategory = $category->replicate();
                $newCategory->parent_id = $otherParentId;
                $newCategory->is_root = 0;
                $newCategory->level = $otherNewLevel;
                $newCategory->category_name = $data['category_name'];
                $newCategory->description = $data['description'] ?? $category->description;
                $newCategory->save();

                // Nhân bản toàn bộ cây con cháu cho bản ghi mới
                $this->replicateChildrenRecursively($category, $newCategory);
            }

        } else {
            // Chuyển thành Root (Cấp 1)
            $duplicateRootQuery = Category::where('is_root', 1)->where('category_name', $data['category_name']);
            if ($category->is_root == 1 && $category->category_name == $data['category_name']) {
                $duplicateRootQuery->where('id', '!=', $category->id);
            }
            if ($duplicateRootQuery->exists()) {
                return back()->withInput()->withErrors(['category_name' => 'Đã tồn tại danh mục gốc (Level 1) có tên này!']);
            }

            $category->update([
                'category_name' => $data['category_name'],
                'description' => $data['description'] ?? $category->description,
                'is_root' => 1,
                'parent_id' => null,
                'level' => 1
            ]);
            $this->updateChildrenRecursively($category);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Hàm đệ quy cập nhật lại level cho cây hiện tại
     */
    private function updateChildrenRecursively($parent)
    {
        foreach ($parent->children as $child) {
            $newChildLevel = $parent->level + 1;
            $child->update([
                'level' => $newChildLevel,
                'parent_id' => $parent->id
            ]);
            $this->updateChildrenRecursively($child);
        }
    }

    /**
     * Hàm đệ quy nhân bản toàn bộ cây con sang cha mới
     */
    private function replicateChildrenRecursively($originalParent, $newParent)
    {
        foreach ($originalParent->children as $originalChild) {
            $newChild = $originalChild->replicate();
            $newChild->parent_id = $newParent->id;
            $newChild->level = $newParent->level + 1;
            $newChild->save();

            // Tiếp tục đệ quy nếu thằng con cũng có cháu
            $this->replicateChildrenRecursively($originalChild, $newChild);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Quy tắc 2: Danh mục có sản phẩm không xóa
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục đang có sản phẩm!');
        }

        // Quy tắc 3: Danh mục cấp 1, cấp 2 có con không xóa
        // (Vì nếu cấp 1, 2 có con thì xóa nó sẽ làm đứt gãy cây, con cháu mất cha)
        if ($category->level <2 && $category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục đang có danh mục con!');
        }

        // Quy tắc 1: Là con cấp 3 && Không có sản phẩm -> Cho xóa
        // (Hai điều kiện trên đã chặn hết các trường hợp khác, đến đây chắc chắn là cấp 3 và 0 sản phẩm)
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
