<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;
    protected $table = 'brands';

    protected $primaryKey = 'id';

    protected $fillable = [
        'brand_name'
    ];
    public $timestamps = true;
    // 1 Brand có nhiều Product
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

}
