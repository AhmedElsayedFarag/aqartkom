<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'code' , 'type' ,
        'value' , 'max_use' , 'current_usage' ,
        'expire_at' , 'is_active',
        'start_at','usage','commission'
    ];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Coupon\Database\factories\CouponFactory::new();
    // }
}
