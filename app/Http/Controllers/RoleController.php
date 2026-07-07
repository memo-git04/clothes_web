<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use http\Env\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('name', '!=', 'customer')->get();
        return view('admin.modules.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Role::create([
            'name' => $request->name,
        ]);
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.modules.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role->update(
            [
                'name' => $request->name,
            ]
        );

        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //check if role has any users assigned
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò này vì có người dùng đang được gán!');
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được xóa thành công!');
    }

    public function editPermissions(Role $role)
    {
        // Lấy tất cả permission
        $allPermissions = Permission::all();

        // Group theo module (product.view → product)
        $permissions = $allPermissions->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        return view('admin.modules.role.assign_permission', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }
    public function updatePermissions(\Illuminate\Http\Request $request, Role $role)
    {
        $permissions = $request->input('permissions', []);

        $role->syncPermissions($permissions);

        return back()->with('success', 'Cập nhật thành công!');
    }

}
