<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'instagram',
        'phone',
        'chat_link',
        'is_active',
    ];
}
