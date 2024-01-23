<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Package\Enums\PackageFeatureTypeEnum;

class SubscriptionFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'feature_title',
        'feature_type',
        'feature_value',
        'package_feature_id',
        'start_count',
        'remaining_count',
    ];

    protected $casts = [
        'feature_value' => 'json',
        'feature_type'  => PackageFeatureTypeEnum::class,
    ];
}
