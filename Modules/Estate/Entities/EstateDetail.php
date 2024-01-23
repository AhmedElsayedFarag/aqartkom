<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'estate_id',
        'estate_attribute_id',
        'type',
        'estate_attribute_value_id',
        'value',
    ];
    protected $casts = [
        'value' => 'array',
    ];

    public function attribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EstateAttribute::class, 'estate_attribute_id');
    }
    public function attributeValue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EstateAttributeValue::class, 'estate_attribute_value_id');
    }
}