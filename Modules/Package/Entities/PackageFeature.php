<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Package\Enums\PackageFeatureTypeEnum;

class PackageFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'json',
        'type' => PackageFeatureTypeEnum::class,
    ];
}