<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'ip_address',
        'nickname_name',
        'description',
        'trace',
        'success',
    ];
}
