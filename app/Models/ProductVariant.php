<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_variants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'sku',
        'stock_quantity',
        'base_price',
        'selling_price',
        'original_price'
    ];
    public $timestamps = true;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    //get image first
    public function firstImg(){
        return $this->hasOne(ProductImage::class)->orderBy('sort_order');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
