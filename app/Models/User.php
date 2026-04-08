<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
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
