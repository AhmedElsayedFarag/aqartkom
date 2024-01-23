<?php

namespace Modules\CustomerMessage\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateAttribute;

class CustomerMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'notes',
    ];
}
