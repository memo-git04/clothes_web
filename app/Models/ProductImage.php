<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;
    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_variant_id',
        'image_url',
        'sort_order',
        'is_main'
    ];
    public $timestamps = true;
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
