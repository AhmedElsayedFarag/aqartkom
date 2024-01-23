<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Modules\Transaction\Contracts\IPaidPackage;

class Package extends Model implements IPaidPackage
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'months',
        'user_type'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function features()
    {
        return $this->hasMany(PackageFeature::class);
    }
    public function scopeType(Builder $query, string $type)
    {
        return $query->where('user_type', $type);
    }
}