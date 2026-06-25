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
        'level',
        'is_root',
        'order',
    ];
    public $timestamps = true;

    // Thêm hàm lấy tất cả cha (ancestors) đệ quy
    public function getAllParents()
    {
        $parents = collect();

        $currentParents = $this->parents;

        while ($currentParents->isNotEmpty()) {
            $parents = $parents->merge($currentParents);
            $nextLevel = collect();

            foreach ($currentParents as $parent) {
                $nextLevel = $nextLevel->merge($parent->parents);
            }

            $currentParents = $nextLevel;
        }

        return $parents->unique('id');
    }



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
    public function parents()
    {
        return $this->belongsToMany(Category::class, 'category_parent', 'category_id', 'parent_id')
            ->withPivot('order')
            ->orderBy('order');
    }

    // Category con
    public function children()
    {
        return $this->belongsToMany(Category::class, 'category_parent', 'parent_id', 'category_id')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
