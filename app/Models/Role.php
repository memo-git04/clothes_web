<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'guard_name',
    ];
    public $timestamps = true;

}
