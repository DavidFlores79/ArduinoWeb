<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_permission_profile')->with('permissions');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'module_permission_profile')->withPivot('module_id');
    }

    public function profile_modules()
    {
        return $this->belongsToMany(Module::class, 'module_permission_profile')->select('module_id','name');
    }

}
