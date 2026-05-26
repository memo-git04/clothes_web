<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'method',
        'transaction_id',
        'amount',
        'status',
        'paid_at'
    ];
    public $timestamps = true;
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
