<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    protected $fillable=[
        'user_id',
        'module_id',
        'active'
    ];
}
