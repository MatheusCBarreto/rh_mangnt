<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function detail()
    {
        // each user has one detail
        return $this->hasOne(UserDetails::class);
    }

    public function department()
    {
        // this user belongs to one department
        return $this->belongsTo(Department::class);
    }
}
