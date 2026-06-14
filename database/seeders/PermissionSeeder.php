<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'product',
            'category',
            'brand',
            'order',
            'user'
        ];
        $actions = [
            'view',
            'create',
            'edit',
            'delete'
        ];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
