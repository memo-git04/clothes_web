<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    /** @use HasFactory<\Database\Factories\SizeFactory> */
    use HasFactory;
    protected $table = 'sizes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'size_name'
    ];
    public $timestamps = true;
    // 1 size có nhiều variant
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }
}
