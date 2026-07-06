<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::all();
        return view('admin.modules.size.index_size', [
            'sizes' => $sizes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.size.add_size');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        Size::create([
            'size_name' => $request->size_name,
        ]);
        //return
        return redirect()->route('admin.sizes.index')
            ->with('success', 'Thêm kích thước thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('admin.modules.size.edit_size', [
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $size->update([
            'size_name' => $request->size_name,
        ]);
        return redirect()->route('admin.sizes.index')
            ->with('success', 'Cập nhật kích thước thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //check if size is used in product variants
        if ($size->productVariants()->count() > 0) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Không thể xóa kích thước này vì có sản phẩm liên quan!');
        }
        $size->delete();
        return redirect()->route('admin.sizes.index');
    }
}
