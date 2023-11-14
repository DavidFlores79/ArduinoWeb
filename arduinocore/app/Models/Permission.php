<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'status',
    ];

    public function profiles(){
        return $this->belongsToMany(Profile::class,'module_permission_profile')->withTimestamps()
            ->withPivot('module_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_permission_profile')->withTimestamps()
            ->withPivot('profile_id');
    }
}
