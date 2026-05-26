<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $fillable = [
        'material_name'
    ];
    public $timestamps = true;
    // 1 material có nhiều product
    public function products()
    {
        return $this->hasMany(Product::class, 'material_id');
    }
}
