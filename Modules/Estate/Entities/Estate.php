<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Ad\Entities\Ad;
use Modules\Auction\Entities\Auction;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Neighborhood\Entities\Neighborhood;

class Estate extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'area',
        'category_id',
        'city_id',
        'neighborhood_id',
        'age',
        'bedroom',
        'is_building',
        'is_furniture',
        'lat',
        'long',
        'address',
        'type',
        'geo_hash',
        // 'estatable_id',
        // 'estatable_type',
    ];

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function neighborhood(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }
    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EstateDetail::class);
    }
    public function media(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EstateMedia::class);
    }
    public function images()
    {
        return $this->hasMany(EstateMedia::class)->where('type', 'image');
    }
    public function auction()
    {
        return $this->hasOne(Auction::class);
    }
    public function ad()
    {
        return $this->hasOne(Ad::class);
    }
}