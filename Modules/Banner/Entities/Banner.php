<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Ad\Entities\Ad;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['ad_id', 'url'];
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>  Storage::disk("banners")->url($attributes['url']),
        );
    }
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
