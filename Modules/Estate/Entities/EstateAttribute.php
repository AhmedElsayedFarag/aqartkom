<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'type',
        'unit',
    ];

    public function values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EstateAttributeValue::class);
    }
}