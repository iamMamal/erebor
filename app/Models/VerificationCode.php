<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = [
        'mobile',
        'code',
        'expires_at',
        'used_at',
        'failed_attempts',
        'locked_until',
    ];

    protected $dates = [
        'expires_at',
        'used_at',
    ];
}
