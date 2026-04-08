<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function users() {
        // each department has many users
        return $this->belongsToMany(User::class);
    }
}
