<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class EstateMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'url',
        'type',
        'storage_location',
        'estate_id',
        'is_converted',
        'new_url'
    ];
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['storage_location'] == "local" ? asset($attributes['url']) : Storage::disk("s3")->url($attributes['url']),
        );
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}