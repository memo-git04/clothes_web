<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return view('admin.modules.material.index_material', [
            'materials' => $materials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.material.add_material');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        Material::create([
            'material_name' => $request->material_name,
        ]);
        //return
        return redirect()->route('admin.materials.index')
            ->with('success', 'Thêm chất liệu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('admin.modules.material.edit_material', [
            'material' => $material
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update([
            'material_name' => $request->material_name,
        ]);
        return redirect()->route('admin.materials.index')->with('success', 'Cập nhật chất liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        //check if the material is used in any products
        if ($material->products()->count() > 0) {
            return redirect()->route('admin.materials.index')->with('error', 'Không thể xóa chất liệu này vì nó đang được sử dụng trong sản phẩm!');
        }
        $material->delete();
        return redirect()->route('admin.materials.index');
    }
}
