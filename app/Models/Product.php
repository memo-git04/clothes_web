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
        'material_id',
        'status'
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
    public function getStockStatusAttribute()
    {
        // không có variant
        if ($this->variants()->count() == 0) {
            return 'inactive';
        }

        $totalStock = $this->variants()->sum('stock_quantity');

        if ($totalStock == 0) {
            return 'out_of_stock';
        }

        if ($totalStock < 10) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
