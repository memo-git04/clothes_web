<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create Super Admin duy nhat
        if (User::count() === 0){
            $admin = User::create([
                'user_name'         => 'super_admin',
                'full_name'         => 'Mai Mai',
                'email'             => 'mainguyen@gmail.com',
                'phone'             => '0987654321',
                'password'          => bcrypt('1234567890'), // ← Nên đổi sau khi seed
                'status'            => 'active',
                'email_verified_at' => now(),
            ]);
            $adminRole = Role::where('name', 'admin')->first();
            $admin->assignRole($adminRole);
            $this->command->info('Super Admin đã được tạo thành công');
            $this->command->info('Email: mainguyen@gmail.com');
            $this->command->info('Password: 1234567890');
        }else{
            $this->command->info('Đã có user trong database, bỏ qua tạo Super Admin.');
        }
    }
}
