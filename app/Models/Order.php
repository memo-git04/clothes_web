<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    // Hằng số trạng thái (khớp bảng order_statuses)
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_PACKING   = 2; // Chờ lấy hàng
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_COMPLETED = 4; // Giao thành công
    const STATUS_CANCELLED = 5; // Hủy

    protected $fillable = [
        'user_id',
        'order_code',
        'promotion_id',
        'status_id',
        'total_amount',
        'discount_amount',
        'final_amount',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
    ];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
