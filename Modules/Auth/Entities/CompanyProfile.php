<?php

namespace Modules\Auth\Entities;

use Modules\Auth\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Modules\Ad\Entities\Ad;
use Modules\City\Entities\City;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'logo',
        'description',
        'lat',
        'long',
        'city_id',
        'whatsapp_number',
        'commercial_register_number',
        'name',
        'qr_code',
    ];

    /**
     * Get the user that owns the company profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shareLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => route('share-company', ['company' => $attributes['uuid']]),
        );
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedLogo(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::disk('companies')->url($attributes['logo']),
        );
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id', 'user_id');
    }
}