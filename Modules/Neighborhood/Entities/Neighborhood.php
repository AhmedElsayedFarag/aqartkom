<?php

namespace Modules\Neighborhood\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;
use Modules\Estate\Entities\Estate;

class Neighborhood extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'name'];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function scopeFilterCity(Builder $query, int $cityId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('neighborhoods.city_id', $cityId);
    }
    public function estates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Estate::class)->where('type', 'ad');
    }
}