<?php

namespace Modules\Ad\Services;

use App\DataTransferObjects\CoordinateDto;
use App\Exceptions\AdIsAlreadyFeaturedException;
use App\Exceptions\AdIsNotApprovedException;
use App\Exceptions\AdIsNotClosedException;
use App\Helpers\Geohash;
use App\Notifications\AdIsAcceptedNotification;
use App\Notifications\AdIsCancelledNotification;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Actions\CreateAd;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdRequest;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Ad\Traits\BaseUserAdQuery;
use Modules\Ad\Traits\FeaturedUserAds;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Services\CouponService;
use Modules\Estate\Sort\Age as SortAge;
use Modules\Estate\Sort\Area as SortArea;
use Modules\Estate\Sort\Price;
use Modules\Estate\Sort\Recent;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Filters\Age;
use Modules\Estate\Filters\Area;
use Modules\Estate\Filters\Bedroom;
use Modules\Estate\Filters\Category;
use Modules\Estate\Filters\City;
use Modules\Estate\Filters\CompanyFilter;
use Modules\Estate\Filters\Furniture;
use Modules\Estate\Filters\Map;
use Modules\Estate\Filters\MarketerFilter;
use Modules\Estate\Filters\Neighborhood;
use Modules\Estate\Filters\Prices;
use Modules\Estate\Filters\Type;
use Modules\Estate\Services\EstateService;
use Modules\Estate\Filters\Search;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Setting\Services\SettingsService;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Transaction\DTO\PaymentAmountDTO;
use Modules\Transaction\DTO\PaymentDTO;
use Modules\Transaction\Enums\PaymentTypeEnum;
use Modules\Transaction\Services\PaymentService;

class AdService
{

    use BaseUserAdQuery, FeaturedUserAds;
    public function createOrUpdate(AdDto $adDto, EstateDto $estateDto, ?Ad $ad = null): ?Ad
    {
        DB::transaction(function () use (&$ad, $estateDto, $adDto) {
            $estateService = new EstateService();
            if (is_null($ad)) {
                $ad = (new CreateAd())->handle($adDto, $estateDto);
                return;
            }
            $estate = $estateService->createOrUpdate($estateDto, $ad->estate);
            $adDto->setEstateID($estate->id);
            $ad->update([
                ...$adDto->toArray(),
                // 'status' => 'pending',
                // 'accepted_at' => null,
            ]);
        });
        $this->loadRelations($ad);
        return $ad;
    }

    public function createOrUpdateAdMarket(AdDto $adDto, EstateDto $estateDto, ?Ad $ad = null): ?Ad
    {
        DB::transaction(function () use (&$ad, $estateDto, $adDto) {
            $estateService = new EstateService();
            if (is_null($ad)) {
                SubscriptionService::checkHasActiveSubscription();
                $activeSubscription = SubscriptionService::getActiveSubscription();
                $feature = $activeSubscription->getFeature(PackageFeatureTypeEnum::MarketingAdByMarketer);
                $handler = new IncrementFeatureUsageHandler();
                $estate = $estateService->createOrUpdate($estateDto);
                $adDto->setEstateID($estate->id);
                $ad = Ad::create(
                    [
                        // 'is_dependable' => true,
                        'accepted_at' => now(),
                        'status' => 'approved',
                        'is_request' => 1,
                        ...$adDto->toArray()
                    ]
                );
                // $ad->status = 'pending';
                $ad->views = 0;
                $handler->handle($feature, $ad);
                // $ad->accepted_at = null;
            } else {
                $estate = $estateService->createOrUpdate($estateDto, $ad->estate);
                $adDto->setEstateID($estate->id);
                $ad->update([
                    ...$adDto->toArray(),
                    // 'status' => 'pending',
                    // 'accepted_at' => null,
                ]);
            }
        });
        $this->loadRelations($ad);
        return $ad;
    }
    public function getMapAds()
    {
        $query = Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'user_id', 'is_dependable', 'is_featured', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_request', 'is_licensed', 'status'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.images' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
            ])
            ->where('status', AdStatusEnum::APPROVED)

            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', false);
                })->orWhere(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', true)
                        ->whereNotNull('license_number');
                });
            })
            // ->where('is_licensed', true)

            ->orderByDesc('ads.is_licensed')
            ->orderByDesc('ads.is_featured');

        $center = request()->get('center');
        $lat = $center['lat'];
        $long = $center['long'];
        $query->selectRaw("ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat))+COS(RADIANS(lat))*COS(RADIANS($lat))*COS(RADIANS(estates.long)-RADIANS($long)))*6380 as distance")
            ->orderBy('distance');

        return app(Pipeline::class)
            ->send($query)
            ->through([
                Age::class,
                Area::class,
                Bedroom::class,
                Category::class,
                City::class,
                Furniture::class,
                Neighborhood::class,
                Prices::class,
                Type::class,
                Search::class,
                SortAge::class,
                SortArea::class,
                Price::class,
                Recent::class,
                Map::class,
                CompanyFilter::class,
                MarketerFilter::class,
            ])
            ->thenReturn()
            ->orderByDesc('ads.accepted_at');
    }
    public function getAll()
    {
        $query = Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'user_id', 'is_dependable', 'is_featured', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_request', 'is_licensed', 'status'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.images' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
            ])
            ->where('status', AdStatusEnum::APPROVED)

            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', false);
                })->orWhere(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', true)
                        ->whereNotNull('license_number');
                });
            })
            // ->where('is_licensed', true)

            ->orderByDesc('ads.is_featured')
            ->orderByDesc('ads.is_licensed');
        if (request()->has('center') && request()->has('second_point')) {
            $center = request()->get('center');
            $lat = $center['lat'];
            $long = $center['long'];
            $query->selectRaw("ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat))+COS(RADIANS(lat))*COS(RADIANS($lat))*COS(RADIANS(estates.long)-RADIANS($long)))*6380 as distance")
                ->orderBy('distance');
        }
        return app(Pipeline::class)
            ->send($query)
            ->through([
                Age::class,
                Area::class,
                Bedroom::class,
                Category::class,
                City::class,
                Furniture::class,
                Neighborhood::class,
                Prices::class,
                Type::class,
                Search::class,
                SortAge::class,
                SortArea::class,
                Price::class,
                Recent::class,
                Map::class,
                CompanyFilter::class,
                MarketerFilter::class,
            ])
            ->thenReturn()
            ->orderByDesc('ads.accepted_at');
    }
    public function getFeatured()
    {
        $query = Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'user_id', 'is_dependable', 'is_featured', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_request', 'is_licensed', 'status'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.images' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
            ])
            ->where('status', AdStatusEnum::APPROVED)

            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', false);
                })->orWhere(function ($query) {
                    $query->where('is_request', 0)
                        ->where('is_licensed', true)
                        ->whereNotNull('license_number');
                });
            })
            // ->where('is_licensed', true)
            ->where('is_featured', true)
            ->orderByDesc('ads.is_licensed')
            ->orderByDesc('ads.is_featured');
        if (request()->has('center') && request()->has('second_point')) {
            $center = request()->get('center');
            $lat = $center['lat'];
            $long = $center['long'];
            $query->selectRaw("ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat))+COS(RADIANS(lat))*COS(RADIANS($lat))*COS(RADIANS(estates.long)-RADIANS($long)))*6380 as distance")
                ->orderBy('distance');
        }
        return app(Pipeline::class)
            ->send($query)
            ->through([
                Age::class,
                Area::class,
                Bedroom::class,
                Category::class,
                City::class,
                Furniture::class,
                Neighborhood::class,
                Prices::class,
                Type::class,
                Search::class,
                SortAge::class,
                SortArea::class,
                Price::class,
                Recent::class,
                Map::class,
                CompanyFilter::class,
                MarketerFilter::class,
            ])
            ->thenReturn()
            ->orderByDesc('ads.accepted_at');
    }

    /**
     * return ad marketing requests
     *
     */
    public function getAllAdMarketing()
    {
        $query = Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'user_id', 'is_dependable', 'is_featured', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_request', 'is_licensed'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.images' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
            ])
            ->where('status', AdStatusEnum::APPROVED)
            ->where('is_request', 1)
            ->orderByDesc('ads.is_featured');
        if (request()->has('center') && request()->has('second_point')) {
            $center = request()->get('center');
            $lat = $center['lat'];
            $long = $center['long'];
            $query->selectRaw("ACOS(SIN(RADIANS(lat))*SIN(RADIANS($lat))+COS(RADIANS(lat))*COS(RADIANS($lat))*COS(RADIANS(estates.long)-RADIANS($long)))*6380 as distance")
                ->orderBy('distance');
        }
        return app(Pipeline::class)
            ->send($query)
            ->through([
                Age::class,
                Area::class,
                Bedroom::class,
                Category::class,
                City::class,
                Furniture::class,
                Neighborhood::class,
                Prices::class,
                Type::class,
                Search::class,
                SortAge::class,
                SortArea::class,
                Price::class,
                Recent::class,
                Map::class,
                // CompanyFilter::class,
                // MarketerFilter::class,
            ])
            ->thenReturn()
            ->orderByDesc('ads.accepted_at');
    }

    public function search()
    {
        $query = Ad::select(['estate_id', 'uuid', 'ads.id', 'accepted_at'])
            ->join('estates', 'estates.id', '=', 'ads.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'area', 'title']),
            ])
            ->where('status', AdStatusEnum::APPROVED);
        return app(Pipeline::class)
            ->send($query)
            ->through([
                Search::class,
            ])
            ->thenReturn()
            ->orderByDesc('ads.accepted_at');
    }

    public  function getAdminAll()
    {
        return app(Pipeline::class)
            ->send(Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'status', 'owner_name', 'owner_phone', 'instrument_number', 'license_number', 'advertiser_relation', 'is_licensed'])
                ->join('estates', 'estates.id', '=', 'ads.estate_id')
                ->where('is_request', 0)
                ->where('is_license_request', false)
                ->where('is_licensed', true)
                ->with([
                    'estate' => fn ($query) => $query->select(['id',  'title', 'city_id', 'category_id']),
                    'estate.city' => fn ($query) => $query->select(['id', 'name']),
                    'estate.category' => fn ($query) => $query->select(['id', 'name'])
                ]))
            ->through([
                City::class,
                Search::class,
                Type::class,
            ])
            ->thenReturn()
            ->orderBy('ads.created_at', 'DESC');
    }
    public  function getUnlicensedAdminAll()
    {
        return app(Pipeline::class)
            ->send(Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'status', 'owner_name', 'owner_phone', 'instrument_number', 'license_number', 'advertiser_relation', 'is_licensed'])
                ->join('estates', 'estates.id', '=', 'ads.estate_id')
                ->where('is_request', 0)
                ->where('is_license_request', false)
                ->where('is_licensed', false)
                ->with([
                    'estate' => fn ($query) => $query->select(['id',  'title', 'city_id', 'category_id']),
                    'estate.city' => fn ($query) => $query->select(['id', 'name']),
                    'estate.category' => fn ($query) => $query->select(['id', 'name'])
                ]))
            ->through([
                City::class,
                Search::class,
                Type::class,
            ])
            ->thenReturn()
            ->orderBy('ads.created_at', 'DESC');
    }
    public  function getAdminLicenseRequestsAll(bool $isCompleted)
    {
        return app(Pipeline::class)
            ->send(Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'status', 'owner_name', 'owner_phone', 'instrument_number', 'license_number', 'advertiser_relation', 'is_licensed'])
                ->join('estates', 'estates.id', '=', 'ads.estate_id')
                // ->where('is_request', 0)
                ->where('is_license_request', true)
                ->where('is_licensed', $isCompleted)
                ->with([
                    'estate' => fn ($query) => $query->select(['id',  'title', 'city_id', 'category_id']),
                    'estate.city' => fn ($query) => $query->select(['id', 'name']),
                    'estate.category' => fn ($query) => $query->select(['id', 'name'])
                ]))
            ->through([
                City::class,
                Search::class,
                Type::class,
            ])
            ->thenReturn()

            ->orderBy('ads.created_at', 'DESC');
    }

    public  function getAdminAllMarketing()
    {
        return app(Pipeline::class)
            ->send(Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'status', 'owner_name', 'owner_phone', 'instrument_number', 'advertiser_relation', 'is_request'])
                ->join('estates', 'estates.id', '=', 'ads.estate_id')
                ->where('is_request', 1)
                ->with([
                    'estate' => fn ($query) => $query->select(['id',  'title', 'city_id', 'category_id']),
                    'estate.city' => fn ($query) => $query->select(['id', 'name']),
                    'estate.category' => fn ($query) => $query->select(['id', 'name'])
                ]))
            ->through([
                City::class,
                Search::class,
                Type::class,
            ])
            ->thenReturn()
            ->orderBy('ads.created_at', 'DESC');
    }

    public function getUserBaseFilters()
    {
        return [
            Age::class,
            Area::class,
            Bedroom::class,
            Category::class,
            Furniture::class,
            Prices::class,
            Type::class,
        ];
    }
    public function updateStatus(Ad $ad, string $status)
    {
        $ad->update(['status' => $status]);
    }
    public function getUserAds(int $userID, string $status, bool $is_license_request = false)
    {
        return app(Pipeline::class)
            ->send(
                $this->baseUserAdQuery()
                    ->where('is_license_request', $is_license_request)
                    ->normalAd()
                    ->owner($userID)
                    ->status($status)
                    ->orderByDesc('ads.id')
            )
            ->through($this->getUserBaseFilters())
            ->thenReturn()
            ->paginate(15);
    }

    public function getUserUnlicensedAds(int $userID)
    {
        return app(Pipeline::class)
            ->send(
                Ad::select(['estate_id', 'uuid', 'ads.type', 'views', 'accepted_at', 'price', 'is_dependable', 'is_featured', 'status', 'ad_type_id', 'instrument_number', 'advertiser_relation', 'is_license_request', 'license_number', 'owner_name'])
                    ->join('estates', 'estates.id', '=', 'ads.estate_id')
                    ->with([
                        'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                        'estate.media' => fn ($query) => $query->select(['estate_id', 'url', 'storage_location', 'type']),
                        'estate.category' => fn ($query) => $query->select(['id', 'name']),
                        'estate.city' => fn ($query) => $query->select(['id', 'name']),
                        'subtype:id,name'
                    ])
                    ->where([
                        ['license_number', null],
                        ['is_license_request', 0],
                        ['is_licensed', 0],
                        ['user_id', $userID]
                    ])
                    ->orderByDesc('ads.id')
            )
            ->through([
                Age::class,
                Area::class,
                Bedroom::class,
                Category::class,
                Furniture::class,
                Prices::class,
                Type::class,
            ])
            ->thenReturn()
            ->paginate(15);
    }


    public function getUserLicenseAdRequests(int $userID, string $status, bool $licensed = true)
    {
        return (new AdLicenseService)->getUserLicense($userID, $status);
    }
    public function getUserLicensedAds(int $userID, string $status)
    {
        return  $this->baseUserAdQuery()
            ->normalAd()
            ->owner($userID)
            ->licenseStatus($status)
            ->status('approved')
            ->orderByDesc('ads.id')->paginate(15);
    }
    public function getUserAdMarketing(int $userID, string $status)
    {
        return app(Pipeline::class)
            ->send(
                $this->baseUserAdQuery()
                    ->where('is_request', 1)
                    ->owner($userID)
                    ->status($status)
                    ->orderByDesc('ads.id')
            )
            ->through($this->getUserBaseFilters())
            ->thenReturn()
            ->paginate(15);
    }
    public function getRelations()
    {
        return [
            'estate',
            'estate.media' => fn ($query) => $query->select(['uuid', 'estate_id', 'url', 'type', 'storage_location']),
            'estate.details' => fn ($query) => $query->select(['estate_id', 'estate_attribute_id', 'estate_attribute_value_id', 'value']),
            'estate.details.attribute' => fn ($query) => $query->select(['id', 'name', 'type', 'unit']),
            'estate.details.attributeValue' => fn ($query) => $query->select(['id', 'value']),
            'estate.city' => fn ($query) => $query->select(['id', 'name']),
            'estate.neighborhood' => fn ($query) => $query->select(['id', 'name']),
            'estate.category' => fn ($query) => $query->select(['id', 'name']),
            'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'type', 'email', 'nationality_id']),
            'subtype:id,name'
        ];
    }
    public function loadRelations(Ad &$ad)
    {
        $ad->load($this->getRelations());
    }
    public function unactive(Ad $ad)
    {
        if ($ad->status != AdStatusEnum::APPROVED) {
            throw new AdIsNotApprovedException();
        }
        $this->updateStatus($ad, 'closed');
    }
    public function active(Ad $ad)
    {
        if ($ad->status != AdStatusEnum::CLOSED) {
            throw new AdIsNotClosedException();
        }
        $this->updateStatus($ad, 'approved');
    }
    public function isAdOwner(Ad $ad)
    {
        \abort_if($ad->user_id != auth()->id(), 404);
    }
    public function accept(Ad $ad)
    {
        $this->updateStatus($ad, 'approved');
        $ad->accepted_at = now();
        // $ad->is_dependable = true;
        if ($ad->owner->type != 'admin')
            $ad->owner->notify(new AdIsAcceptedNotification($ad->owner->mobile_token));
        $ad->save();
    }
    public function cancel(Ad $ad)
    {
        $this->updateStatus($ad, 'cancelled');
        $ad->owner->notify(new AdIsCancelledNotification($ad->owner->mobile_token));
        $ad->save();
    }
    public function isFeatured(Ad $ad)
    {
        if ($ad->is_featured && $ad->featured_expires_at->isFuture()) {
            throw new AdIsAlreadyFeaturedException();
        }
    }
    public function addFeature(Ad $ad, int $days)
    {
        if ($ad->is_featured) {
            $ad->update([
                'featured_expires_at' => Carbon::parse($ad->featured_expires_at)->addDays($days),
            ]);
        } else
            $ad->update([
                'is_featured' => true,
                'featured_at' => now(),
                'featured_expires_at' => now()->addDays($days),
            ]);
    }
    public function payFees(Ad $ad)
    {
        $this->isAdOwner($ad);
        \abort_if($ad->status->value != 'pending', 404);

        request()->validate([
            'payment_method' => 'required|numeric',
            'coupon' => 'nullable|string|min:3|max:255',
        ]);
        $paymentService = new PaymentService();
        $userType = auth()->user()->type;
        $licensePriceKey = match ($userType) {
            'owner' => 'ad-license-price',
            'marketer' => 'ad-license-marketer-price',
            'company' => 'ad-license-company-price',
        };
        $price = floatval(SettingsService::getSingle('ad_license', $licensePriceKey)['value']);
        if (request()->has('coupon')) {
            $coupon = Coupon::where('code', request()->coupon)->where('usage', 'services')->first();
            CouponService::validate($coupon);
        }
        $amountDto = new PaymentAmountDTO($price, request()->get('coupon'));
        $paymentDto = new PaymentDTO(
            auth()->user()->name,
            auth()->user()->phone,
            auth()->user()->email,
            PaymentTypeEnum::AdvertisingLicense,
            request()->payment_method,
            $ad,
            $amountDto,
        );
        return $paymentService->createLink($paymentDto);
    }
    public function getAdsByGeoHash(CoordinateDto $firstPoint, CoordinateDto $secondPoint)
    {
        $minLat = $firstPoint->getLat() < $secondPoint->getLat() ? $firstPoint->getLat() : $secondPoint->getLat();
        $maxLat = $firstPoint->getLat() > $secondPoint->getLat() ? $firstPoint->getLat() : $secondPoint->getLat();
        $minLong = $firstPoint->getLong() < $secondPoint->getLong() ? $firstPoint->getLong() : $secondPoint->getLong();
        $maxLong = $firstPoint->getLong() > $secondPoint->getLong() ? $firstPoint->getLong() : $secondPoint->getLong();
        $geohash = str_split(Geohash::encode($minLat, $minLong), 1);
        $geohash2 = str_split(Geohash::encode($maxLat, $maxLong), 1);
        $geohash3 = str_split(Geohash::encode($minLat, $maxLong), 1);
        $geohash4 = str_split(Geohash::encode($maxLat, $minLong), 1);

        $geohashes = [$geohash, $geohash2, $geohash3, $geohash4];
        //find first repeated characters
        $repeatedString = '';
        for ($i = 0; $i < 12; $i++) {
            if (
                $geohash[$i] == $geohash2[$i]
                && $geohash[$i] == $geohash3[$i]
                && $geohash[$i] == $geohash4[$i]
                && strlen($repeatedString) == $i
            ) {
                $repeatedString .= $geohash[$i];
            }
        }
        dd($repeatedString);
    }
}
