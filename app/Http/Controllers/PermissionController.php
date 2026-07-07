<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = SpatiePermission::all();
        return view('admin.modules.permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        SpatiePermission::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.modules.permission.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $permission->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.permissions.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Xóa thành công!');
    }
    public function assignRole(Permission $permission)
    {
        $roles = Role::where('name', '!=', 'customer')->get();
        return view('admin.modules.permission.assign_role', [
            'permission' => $permission,
            'roles' => $roles
        ]);
    }
    public function assignRoleStore(Request $request, Permission $permission)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $permission->syncRoles($request->roles);

        return redirect()->back()->with('success', 'Gán role thành công!');
    }
}
