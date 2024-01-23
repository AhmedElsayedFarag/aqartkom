<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateAttribute;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'icon', 'is_building', 'background', 'is_price_per_meter', 'is_bedroom_enable'];
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => asset($attributes['icon']),
        );
    }

    /**
     * Get the background url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedBackground(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => asset($attributes['background']),
        );
    }

    public function attributes()
    {
        return $this->hasMany(EstateAttribute::class);
    }
    public function estates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Estate::class);
    }
}