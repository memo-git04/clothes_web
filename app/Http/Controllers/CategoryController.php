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
        $categories = Category::with('parent')->get();
        return view('admin.modules.category.index_category', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.modules.category.add_category',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'category_name' => $request->category_name,
            'parent_id' => $request->parent_id
        ]);
        return redirect()->route('categories.index');
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
    public function edit(Category $category)
    {
        $invalidIds = $category->getAllChildrenIds();
//        dd($invalidIds);
        $categories = Category::all();
        return view('admin.modules.category.edit_category', [
            'category' => $category,
            'categories' => $categories,
            'invalidIds' => $invalidIds
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
//                dd($request->all());
//        dd(Category::find(1));

        $request->validate([
            'update_category' =>[
                'required',
                Rule::unique('categories', 'category_name')->ignore($category->id)
            ]
        ]);
        //root dont have parent
        if ($category->is_root && $request->parent_id){
            return redirect()->back();
        }

        //child is not parent
        if ($request->parent_id){
            $parent = Category::find($request->parent_id);
            if ($parent && $parent->parent_id != null){
                return redirect()->back();
            }
        }
//        dd($category, $parent);
        $category->update([
            'category_name' => $request->update_category,
            'parent_id' => $request->filled('parent_id') ? $request->parent_id : null,
        ]);
//        dd($category, $parent);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
