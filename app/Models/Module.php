<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
        'active'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_modules');
    }

    public function userModules()
    {
        return $this->hasMany(UserModule::class);
    }

}
