<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    use HasFactory;


    public function permission_name()
    {
        return $this->belongsTo(Permission::class, "permission_id");
    }

}
