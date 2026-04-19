<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{

    protected $fillable = [
        'address',
        'zip_code',
        'city',
        'phone',
        'salary',
        'admission_date',
    ];

    public function user()
    {
        // each user details belongs to a single user
        return $this->belongsTo(User::class);
    }
}
