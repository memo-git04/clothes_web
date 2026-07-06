<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.modules.color.index_color', [
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.color.add_color');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        Color::create([
            'color_name' => $request->color_name,
        ]);
//        dd($request->color_name);
        //return
        return redirect()->route('admin.colors.index')
            ->with('success', 'Thêm màu sắc thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.modules.color.edit_color', [
            'color' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        $color->update([
            'color_name' => $request->color_name
        ]);
        return redirect()->route('admin.colors.index')
                ->with('success', 'Cập nhật màu sắc thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        if ($color->productVariants()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa màu sắc này vì có sản phẩm liên quan.');
        }
        $color->delete();
        return redirect()->back()->with('success', 'Xóa màu sắc thành công');
    }
}
