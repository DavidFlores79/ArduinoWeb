<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class,'module_permission_profile')->withTimestamps()
            ->withPivot('permission_id');
    }
    public function permisos(){
        return $this->belongsToMany(Permiso::class,'module_permission_profile')->withTimestamps()
            ->withPivot('profile_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, "category_id");
    }

    public function module_permission()
    {
        return $this->hasMany(ModulePermission::class)->with("permission_name");
    }
}
