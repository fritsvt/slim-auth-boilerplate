<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'ip',
        'cv',
        'available',
        'public_profile',
        'profile_picture',
        'bio',
        'summary',
        'birthday',
        'address',
        'postal_code',
        'city',
        'phone',
        'drivers_license',
        'gender'
    ];

    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
