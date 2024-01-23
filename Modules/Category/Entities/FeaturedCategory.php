<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Entities\City;

class FeaturedCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'city_id',
        'background',
        'type',
        'title'
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    //
    /**
     * Get the background url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => asset($attributes['background']),
        );
    }
}
