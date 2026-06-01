<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_name',
        'description',
        'brand_id',
        'category_id',
        'material_id'
    ];
    public $timestamps = true;
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    //all stock_quantity variants
    public function getTotalStockAttribute()
    {
        return $this->variants->sum('stock_quantity');
    }
    // Status theo rule
    public function getStockStatusAttribute()
    {
        if ($this->total_stock == 0) {
            return 'out_of_stock';
        }

        if ($this->total_stock < 50) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
