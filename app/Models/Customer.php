<?php 

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'google_id',
        'profile_image'
    ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }
}