<?php

namespace Modules\Ad\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'marketer_name',
        'marketer_phone',
    ];
}
