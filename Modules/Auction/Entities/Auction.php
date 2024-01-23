<?php

namespace Modules\Auction\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Estate\Entities\Estate;
use Illuminate\Support\Str;
use Spatie\Sitemap\Contracts\Sitemapable;

class Auction extends Model implements Sitemapable
{
    use HasFactory;

    protected $fillable = ['initial_price', 'top_price', 'estate_id', 'end_at', 'is_closed'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Scope a query to only include closed auctions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeClosed(Builder $query, ?int $status = null)
    {
        $query->when($status, fn ($q) => $q->where('is_closed', $status));
    }

    protected static function newFactory()
    {
        return \Modules\Auction\Database\factories\AuctionFactory::new();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function bidRequests()
    {
        return $this->hasMany(BidRequest::class);
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shareLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => route('front.auction.show', ['auction' => $attributes['uuid']]),
        );
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => __('admin.active_status')[$attributes['is_closed']],
        );
    }
    public function isClosed(): bool
    {
        return ($this->is_closed || now()->isAfter($this->end_at));
    }
    public function toSitemapTag(): \Spatie\Sitemap\Tags\Url|array|string
    {
        return route('front.auction.show', ['auction' => $this->uuid]);
    }
}