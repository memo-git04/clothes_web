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
        'status',
        'txn_ref',
        'transaction_no',
        'amount',
        'paid_at',
    ];
    public $timestamps = true;

    protected $casts = [
        'paid_at' => 'datetime',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
