<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketerContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketer_id',
        'customer_id',
        'customer_name',
        'customer_phone',
        'marketer_phone',
        'marketer_whatsapp',
    ];
}