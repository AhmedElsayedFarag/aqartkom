<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'url', 'type', 'storage_location'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (Media $media) {
            $media->uuid = \generate_uuid(Media::class);
        });
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->select(['id', 'url'])->where('uuid', $value)->firstOrFail();
    }
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
}