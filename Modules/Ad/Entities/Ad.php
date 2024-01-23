<?php

namespace Modules\Ad\Entities;

use App\Models\AdView;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Ad\Enums\AdTypeEnum;
use Modules\Auth\Entities\User;
use Modules\Estate\Entities\Estate;
use Illuminate\Support\Str;

use Modules\Package\Enums\PackageFeatureTypeEnum;

use Modules\Ad\Enums\AdAdvertiser;
use Modules\Transaction\Entities\Transaction;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Spatie\Sitemap\Contracts\Sitemapable;

use Spatie\Sitemap\Tags\Url;

class Ad extends Model implements Sitemapable
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'estate_id',
        'type',
        'status',
        'views',
        'price',
        'is_dependable',
        'accepted_at',
        'owner_name',
        'owner_phone',
        'price_of_meters',
        'ad_type_id',
        'is_featured',
        'featured_at',
        'featured_expires_at',
        'is_request',
        'is_licensed',
        'instrument_number',
        'advertiser_relation',
        'is_license_request',
        'license_number',
        'license_cost',
        'nationality_id',
        'building_number',
        'additional_number',
        'postal_number',
    ];
    protected $casts = [
        'status' => AdStatusEnum::class,
        'advertiser_relation' => AdAdvertiser::class,
        'type'  => AdTypeEnum::class,
        'accepted_at' => 'immutable_datetime'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = \generate_uuid(Ad::class);
        });
    }


    public function estate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Estate::class);
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AdVisit::class);
    }

    public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AdReport::class);
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => __('admin.approved_statuses')[$attributes['status']],
        );
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedAcceptedDate(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $formattedDate = null;
                if (!\is_null($attributes['accepted_at'])) {
                    $formattedDate = \str_replace('منذ', '', Carbon::parse($attributes['accepted_at'])->diffForHumans());
                    $numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    foreach ($numbers as $number) {
                        $formattedDate = \str_replace($number, \get_arabic_number($number), $formattedDate);
                    }
                }
                return $formattedDate;
            },
        );
    }
    /**
     * Get the icon url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shareLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => route('front.aqar.show', ['ad' => $attributes['uuid']]),
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
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->when(strlen($status), function ($builder) use ($status) {
            $builder->where('status', $status);
        });
    }
    public function toSitemapTag(): \Spatie\Sitemap\Tags\Url|array|string
    {
        return route('front.aqar.show', ['ad' => $this->uuid]);
    }
    public function subtype()
    {
        return $this->belongsTo(AdType::class, 'ad_type_id');
    }
    public function adViews()
    {
        return $this->hasMany(AdView::class);
    }

    public function scopeLicenseStatus(Builder $builder, string $status)
    {
        if ($status == 'pending') {
            return $builder->whereNull('license_number');
        }
        return $builder->whereNotNull('license_number');
    }

    public function scopeOwner(Builder $builder, int $userID)
    {
        return $builder->where('user_id', $userID);
    }
    public function scopeNormalAd(Builder $builder)
    {
        return $builder->where('is_request', 0);
    }
    public function scopeLicensed(Builder $builder)
    {
        return $builder->where('is_licensed', 1);
    }
    public function scopeLicenseRequest(Builder $builder)
    {
        return $builder->where('is_request', 0)->where('is_license_request', true);
    }
    public function scopeAdMarketing(Builder $builder)
    {
        return $builder->where('is_request', 1)->where('status', AdStatusEnum::APPROVED);
    }
    public function licenseInvoice()
    {
        return $this->hasOne(Transaction::class, 'transactionable_id')
            ->where('service_type', PaymentTypeEnum::AdvertisingLicense);
    }
    // protected static function newFactory()
    // {
    //     return \Modules\Ad\Database\factories\AdFactory::new();
    // }
}