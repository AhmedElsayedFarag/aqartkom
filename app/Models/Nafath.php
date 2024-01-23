<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nafath extends Model
{
    use HasFactory;
    protected $fillable = [
        'data',
        "requestId",
        "transId",
        "random",
        "nationalId",
        'user_id',
        'type',
        'mobile_token',
        'source'
    ];
}
