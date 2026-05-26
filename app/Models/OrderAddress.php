<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    /** @use HasFactory<\Database\Factories\OrderAddressFactory> */
    use HasFactory;
    protected $table = 'order_addresses'
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'receiver_name',
        'receiver_phone',
        'province',
        'district',
        'ward',
        'detailed_address',
        'notes'
    ];
    public $timestamps = true;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
