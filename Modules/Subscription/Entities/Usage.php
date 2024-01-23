<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_type',
        'user_phone',
        'from_package',
        'title',
        'description',
        'usable_id',
        'usable_type',
    ];
}
