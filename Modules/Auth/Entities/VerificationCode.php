<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'otp', 'expire_at'];

    protected $casts = [
        'expire_at' => 'datetime:Y-m-d H:i:s',
        'otp' => 'integer'
    ];

    const EXPIRY = 30;
}
