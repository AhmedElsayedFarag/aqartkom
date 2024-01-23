<?php

namespace Modules\Ad\Services;

use App\Exceptions\AdIsAlreadyFeaturedException;
use App\Exceptions\AdIsNotApprovedException;
use App\Exceptions\AdIsNotClosedException;
use App\Notifications\AdIsAcceptedNotification;
use App\Notifications\AdIsCancelledNotification;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;

use Modules\Ad\Enums\AdStatusEnum;
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
use Modules\Transaction\Entities\Transaction;
use Illuminate\Support\Str;
use Modules\Ad\DataTransferObject\AdRequestDto;
use Modules\Ad\Entities\AdRequest;
use Modules\Package\Enums\PackageFeatureTypeEnum;
use Modules\Subscription\Services\Features\IncrementFeatureUsageHandler;
use Modules\Subscription\Services\SubscriptionService;

class AdRequestService
{

    public function createOrUpdate(AdRequestDto $adDto, EstateDto $estateDto, ?AdRequest $ad = null): ?AdRequest
    {
        DB::transaction(function () use (&$ad, $estateDto, $adDto) {
            $estateService = new EstateService();
            if (is_null($ad)) {
                SubscriptionService::checkHasActiveSubscription();
                $activeSubscription = SubscriptionService::getActiveSubscription();
                $feature = $activeSubscription->getFeature(PackageFeatureTypeEnum::AdRequest);
                $handler = new IncrementFeatureUsageHandler();

                $estate = $estateService->createOrUpdate($estateDto);
                $adDto->setEstateID($estate->id);
                $ad = AdRequest::create(
                    [
                        // 'is_dependable' => true,
                        'accepted_at' => now(),
                        'status' => 'approved',
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

    // public function createPaymentLink()
    // {
    // }
    // public function paymentCallback()
    // {
    // }


    public function getAll()
    {
        $query = AdRequest::select(['estate_id', 'uuid', 'ad_requests.type', 'views', 'accepted_at', 'price', 'user_id', 'is_dependable', 'is_featured', 'ad_type_id'])
            ->join('estates', 'estates.id', '=', 'ad_requests.estate_id')
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                'estate.category' => fn ($query) => $query->select(['id', 'name']),
                'estate.city' => fn ($query) => $query->select(['id', 'name']),
                'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'phone', 'type']),
            ])
            ->where('status', AdStatusEnum::APPROVED)
            ->orderByDesc('ad_requests.is_featured');
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
            ->orderByDesc('ad_requests.accepted_at');
    }

    public function search()
    {
        $query = AdRequest::select(['estate_id', 'uuid', 'ad_requests.id', 'accepted_at'])
            ->join('estates', 'estates.id', '=', 'ad_requests.estate_id')
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
            ->orderByDesc('ad_requests.accepted_at');
    }

    public  function getAdminAll()
    {
        return app(Pipeline::class)
            ->send(AdRequest::select(['estate_id', 'uuid', 'ad_requests.type', 'views', 'accepted_at', 'price', 'status', 'owner_name', 'owner_phone'])
                ->join('estates', 'estates.id', '=', 'ad_requests.estate_id')
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
            ->orderBy('ad_requests.created_at', 'DESC');
    }

    public function updateStatus(AdRequest $ad, string $status)
    {
        $ad->update(['status' => $status]);
    }

    public function getUserAds(int $userID, string $status)
    {
        return app(Pipeline::class)
            ->send(
                AdRequest::select(['estate_id', 'uuid', 'ad_requests.type', 'views', 'accepted_at', 'price', 'is_dependable', 'is_featured', 'status', 'ad_type_id'])
                    ->join('estates', 'estates.id', '=', 'ad_requests.estate_id')
                    ->with([
                        'estate' => fn ($query) => $query->select(['id', 'city_id', 'category_id', 'area', 'title', 'address', 'lat', 'long', 'bedroom']),
                        'estate.category' => fn ($query) => $query->select(['id', 'name']),
                        'estate.city' => fn ($query) => $query->select(['id', 'name']),
                        'subtype:id,name'
                    ])
                    ->where('user_id', $userID)
                    ->status($status)
                    ->orderByDesc('ad_requests.id')
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

    public function getRelations()
    {
        return [
            'estate',
            'estate.details' => fn ($query) => $query->select(['estate_id', 'estate_attribute_id', 'estate_attribute_value_id', 'value']),
            'estate.details.attribute' => fn ($query) => $query->select(['id', 'name', 'type', 'unit']),
            'estate.details.attributeValue' => fn ($query) => $query->select(['id', 'value']),
            'estate.city' => fn ($query) => $query->select(['id', 'name']),
            'estate.neighborhood' => fn ($query) => $query->select(['id', 'name']),
            'estate.category' => fn ($query) => $query->select(['id', 'name']),
            'owner' => fn ($query) => $query->select(['id', 'phone', 'name', 'type']),
            'subtype:id,name'
        ];
    }

    public function loadRelations(AdRequest &$ad)
    {
        $ad->load($this->getRelations());
    }

    public function unactive(AdRequest $ad)
    {
        if ($ad->status != AdStatusEnum::APPROVED) {
            throw new AdIsNotApprovedException();
        }
        $this->updateStatus($ad, 'closed');
    }

    public function active(AdRequest $ad)
    {
        if ($ad->status != AdStatusEnum::CLOSED) {
            throw new AdIsNotClosedException();
        }
        $this->updateStatus($ad, 'approved');
    }

    public function isAdOwner(AdRequest $ad)
    {
        \abort_if($ad->user_id != auth()->id(), 404);
    }

    public function accept(AdRequest $ad)
    {
        $this->updateStatus($ad, 'approved');
        $ad->accepted_at = now();
        // $ad->is_dependable = true;
        if ($ad->owner->type != 'admin')
            $ad->owner->notify(new AdIsAcceptedNotification($ad->owner->mobile_token));
        $ad->save();
    }

    public function cancel(AdRequest $ad)
    {
        $this->updateStatus($ad, 'cancelled');
        $ad->owner->notify(new AdIsCancelledNotification($ad->owner->mobile_token));
        $ad->save();
    }

    public function isFeatured(AdRequest $ad)
    {
        if ($ad->is_featured && $ad->featured_expires_at->isFuture()) {
            throw new AdIsAlreadyFeaturedException();
        }
    }

    public function addFeature(AdRequest $ad)
    {
        return Transaction::create([
            'user_id' => $ad->user_id,
            'customer_name' => auth()->user()->name,
            'customer_phone' => auth()->user()->phone,
            'amount' => 50,
            'transaction_id' => Str::random(10),
            'uuid' => Str::uuid(),
            'transactionable_id' => $ad->id,
            'transactionable_type' => Ad::class,
        ]);
    }
}