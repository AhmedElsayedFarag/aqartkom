<?php

namespace Modules\Auth\Entities;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Modules\Ad\Entities\Ad;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Entities\BidRequest;
use Modules\Subscription\Entities\Subscription;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected static function newFactory()
    {
        return \Modules\Auth\Database\factories\UserFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'uuid',
        'type',
        'mobile_token',
        'profile',
        'free_ads',
        'is_featured',
        'is_authorized',
        'nationality_id',
        'one_time_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'type',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::created(function ($model) {
            // Assign role & profile
            switch ($model->type) {
                case 'company':
                    $model->assignRole('company');
                    break;

                case 'marketer':
                    $model->assignRole('marketer');
                    break;

                case 'customer':
                    $model->assignRole('customer');
                    break;
                case 'owner':
                    $model->assignRole('owner');
                    break;
            }
        });
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
    /**
     * Get the marketer profile associated with the user.
     */
    public function marketerProfile()
    {
        str_replace(' ', '-', $this->name);
        return $this->hasOne(MarketerProfile::class, 'user_id');
    }

    /**
     * Get the company profile associated with the user.
     */
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class, 'user_id');
    }

    /**
     * Get user subscriptions.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get current active subscription.
     */
    public function activeSubscription()
    {
        return $this->subscriptions()->whereStatus('approved')
            // ->whereDate('start_at', '>=', now()->format('Y-m-d'))
            ->whereDate('end_at', '<=', now()->format('Y-m-d'))
            ->latest()->first();
    }

    /**
     * Get user bids.
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }


    public function favoriteAds()
    {
        return $this->morphedByMany(Ad::class, 'favoritable', 'favorites');
    }
    public function favoriteCompanies()
    {
        return $this->morphedByMany(CompanyProfile::class, 'favoritable', 'favorites');
    }
    public function favoriteAuctions()
    {
        return $this->morphedByMany(Auction::class, 'favoritable', 'favorites');
    }
    /**
     * Get the background url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedProfile(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => asset($attributes['profile']),
        );
    }
    /**
     * Get the background url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedSince(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Carbon::parse($attributes['created_at'])->diffForHumans(),
        );
    }
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
    public function latestNotifications()
    {
        return $this->notifications()->latest()->limit(5);
    }
}