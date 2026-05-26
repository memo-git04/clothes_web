<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name',
        'description',
        'parent_id',
        'is_root',
    ];
    public $timestamps = true;

    //function get all id
    public function getAllChildrenIds()
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }

        return $ids;
    }

    //category parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Category con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
