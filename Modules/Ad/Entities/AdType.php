<?php

namespace Modules\Ad\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
    ];
}