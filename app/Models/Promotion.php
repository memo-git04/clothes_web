<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    /** @use HasFactory<\Database\Factories\PromotionFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'promotion_name',
        'description',
        'discount_value',
        'min_order_amount',
        'usage_limit',
        'current_usage',
        'per_user_limit',
        'start_date',
        'end_date',
        'is_active'
    ];
    public $timestamps = true;
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
