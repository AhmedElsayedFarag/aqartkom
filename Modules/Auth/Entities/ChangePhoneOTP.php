<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangePhoneOTP extends Model
{
    use HasFactory;
    protected $table = "change_phone_o_t_ps";
    protected $fillable = [
        'phone',
        'code',
        'expire_at',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}