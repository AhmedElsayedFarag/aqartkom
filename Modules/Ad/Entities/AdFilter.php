<?php

namespace Modules\Ad\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'values',
        'group',
    ];
    protected $casts = [
        'values' => 'array',
    ];
}