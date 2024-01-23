<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\Package\Entities\Package;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Enums\SubscriptionStatusEnum;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'start_at', 'end_at', 'package_id',
        'package_name', 'user_name', 'user_phone'
    ];
    protected $casts = ['stats' => SubscriptionStatusEnum::class];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function scopeStatus(Builder $query, string $status)
    {
        return $query->where('status', $status);
    }
    public function features()
    {
        return $this->hasMany(SubscriptionFeature::class);
    }
    public function getFeature(PackageFeatureTypeEnum $type)
    {
        $feature = $this->features->filter(function ($feature) use ($type) {
            return $feature->feature_type == $type;
        })->first();
        if (is_null($feature))
            throw new \App\Exceptions\PackageFeatureIsNotFound();
        return $feature;
    }
    public function searchInMultipleFeature(array $features)
    {
        $feature =  $this->features->filter(function ($feature) use ($features) {
            return in_array($feature->feature_type->value, $features);
        })->first();
        if (is_null($feature))
            throw new \App\Exceptions\PackageFeatureIsNotFound();
        return $feature;
    }
    public function scopeValidFilter(Builder $builder)
    {
        return $builder->where('status', 'approved')
            ->where('end_at', '>', now());
    }
}