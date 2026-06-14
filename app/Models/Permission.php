<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
class Permission extends SpatiePermission
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'guard_name',
    ];
    public $timestamps = true;
}
