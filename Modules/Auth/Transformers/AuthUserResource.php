<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Services\SettingsService;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Transformers\SubscriptionShowResource;
use Modules\Users\Transformers\CompanyShowResource;

class AuthUserResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // $activeSubscription = SubscriptionService::getActiveSubscription();
        $subscription =
            SubscriptionService::getActiveSubscription();

        $data =  [
            'id' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'profile' => $this->formattedProfile,
            'phone' => $this->phone,
            'created_at' => $this->formattedSince,
            'token' => $this->createToken('access token')->plainTextToken,
            'type' => $this->type,
            // 'is_subscribed' => $activeSubscription ? true : false,
            // 'subscription' => $activeSubscription ? new SubscriptionShowResource($activeSubscription) : null,
            // 'license_price' => SettingsService::getSingle('ad_license', 'ad-license-price')['value'],
            // 'free_ads' => $this->free_ads,
            'is_subscribed' => !is_null($subscription),
            'subscription' =>  !is_null($subscription) ? new SubscriptionShowResource($subscription) : null,
            // 'license_price' => 0,
            'license_price' => SettingsService::getSingle('ad_license', 'ad-license-price')['value'],
            'free_ads' => $this->free_ads,
            'is_authorized' => $this->is_authorized,
            'unread_notifications' => $this->unreadNotifications()->count(),
        ];
        if ($this->type == 'marketer') {
            $data['advertisement_number'] = $this->marketerProfile->advertisement_number;
            $data['qr_code'] = Storage::disk('marketers')->url($this->marketerProfile->qr_code);
            $data['license_price'] = SettingsService::getSingle('ad_license', 'ad-license-marketer-price')['value'];
            // $data['license_price'] = 0;
        }
        if ($this->type == 'company') {
            $data['company_profile'] = new CompanyShowResource($this->companyProfile);
            $data['license_price'] = SettingsService::getSingle('ad_license', 'ad-license-company-price')['value'];
            // $data['license_price'] = 0;
        }

        return $data;
    }
}