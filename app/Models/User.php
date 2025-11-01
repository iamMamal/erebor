<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'mobile',
        'name',
        'address',
        'password',
        'is_admin',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
    ];

    public function pointsHistory()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function totalPoints()
    {
        return $this->pointsHistory()->sum('points');
    }

    public function packageRequests()
    {
        return $this->hasMany(PackageRequest::class);
    }

}

