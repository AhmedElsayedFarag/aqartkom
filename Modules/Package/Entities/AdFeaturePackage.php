<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Transaction\Contracts\IPaidPackage;

class AdFeaturePackage extends Model implements IPaidPackage
{
    use HasFactory;

    protected $fillable = [
        'title',
        'days',
        'price',
        'type'
    ];
    public function scopeType(Builder $builder, $type)
    {
        return $builder->where('type', $type);
    }
}