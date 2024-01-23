<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Estate\Entities\Estate;
use Modules\Neighborhood\Entities\Neighborhood;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lat', 'long'];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->select(['id', 'name', 'lat', 'long'])->where('id', $value)->firstOrFail();
    }
    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function neighborhoods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Neighborhood::class);
    }
    public function estates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Estate::class)->where('estates.type', 'ad');
    }
}