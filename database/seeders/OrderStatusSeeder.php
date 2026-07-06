<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * 5 trạng thái đơn hàng chuẩn (khớp dữ liệu hiện có trong DB).
     * Dùng updateOrInsert để chạy lại nhiều lần không tạo trùng.
     */
    public function run(): void
    {
        $statuses = [
            1 => 'Chờ xác nhận',
            2 => 'Chờ lấy hàng',
            3 => 'Đang giao',
            4 => 'Giao thành công',
            5 => 'Hủy',
        ];

        foreach ($statuses as $id => $name) {
            DB::table('order_statuses')->updateOrInsert(
                ['id' => $id],
                ['status_name' => $name]
            );
        }

        $this->command->info('Order statuses đã được tạo/cập nhật.');
    }
}
