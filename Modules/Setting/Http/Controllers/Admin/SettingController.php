<?php

namespace Modules\Setting\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Setting\Entities\Settings;
use Modules\Setting\Http\Requests\UpdateApiRequest;
use Modules\Setting\DataTransferObjects\SettingsCollectionDTO;
use Modules\Setting\Http\Requests\UpdateAdFeatureRequest;
use Modules\Setting\Http\Requests\UpdateAdLicenseRequest;
use Modules\Setting\Http\Requests\UpdateAppSettingRequest;
use Modules\Setting\Http\Requests\UpdateAuctionRequest;
use Modules\Setting\Http\Requests\UpdateContactUsRequest;
use Modules\Setting\Http\Requests\UpdateFreePackageRequest;
use Modules\Setting\Services\SettingsService;

class SettingController extends Controller
{
    public function __construct(private SettingsService $settingsService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function apis()
    {
        $settings = $this->settingsService->get('apis');
        $type = "apis";
        return view('setting::update', compact('settings', 'type'));
    }

    public function updateApis(UpdateApiRequest $request)
    {
        $settingsCollection = SettingsCollectionDTO::fromArray($request->validated());
        $this->settingsService->update('apis', $settingsCollection);
        return \success_update('settings-apis.index');
    }

    public function contactUs()
    {
        $settings = $this->settingsService->get('contact-us');
        $type = "contact-us";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateContactUs(UpdateContactUsRequest $request)
    {
        $settingsCollection = SettingsCollectionDTO::fromArray($request->validated());
        $this->settingsService->update('contact-us', $settingsCollection);
        return \success_update('settings-contact-us.index');
    }

    public function auction()
    {
        $settings = $this->settingsService->get('auction');
        $type = "auction";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateAuction(UpdateAuctionRequest $request)
    {
        $data = $request->only(['auction_price']);
        if ($request->has('auction_document'))
            $data['auction_document'] = \upload_image($request->file('auction_document'), 'documents');
        else
            $data['auction_document'] = SettingsService::getSingle('auction', 'auction_document')['value'];
        $settingsCollection = SettingsCollectionDTO::fromArray($data);
        $this->settingsService->update('auction', $settingsCollection);
        return \success_update('settings-auction.index');
    }
    public function appSettings()
    {
        $settings = $this->settingsService->get('app');
        $type = "app";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateApp(UpdateAppSettingRequest $request)
    {

        $data = $request->only(['app_store', 'google_play', 'app_version']);
        if ($request->has('image'))
            $data['image'] = \upload_image($request->file('image'), 'banners');
        else
            $data['image'] = SettingsService::getSingle('app', 'image')['value'];
        if ($request->has('app_popup'))
            $data['app_popup'] = \upload_image($request->file('app_popup'), 'banners');
        else
            $data['app_popup'] = SettingsService::getSingle('app', 'app_popup')['value'];
        $settingsCollection = SettingsCollectionDTO::fromArray($data);
        $this->settingsService->update('app', $settingsCollection);
        return \success_update('settings-app.index');
    }
    public function adFeatureSettings()
    {
        $settings = $this->settingsService->get('ad_feature');
        $type = "ad-feature";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateAdFeature(UpdateAdFeatureRequest $request)
    {
        $settingsCollection = SettingsCollectionDTO::fromArray($request->validated());
        $this->settingsService->update('ad_feature', $settingsCollection);
        return \success_update('settings-ad-feature.index');
    }
    public function adLicenseSettings()
    {
        $settings = $this->settingsService->get('ad_license');
        $type = "ad-license";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateAdLicense(UpdateAdLicenseRequest $request)
    {
        $settingsCollection = SettingsCollectionDTO::fromArray($request->validated());
        $this->settingsService->update('ad_license', $settingsCollection);
        return \success_update('settings-ad-license.index');
    }
    public function freePackageSettings()
    {
        $settings = $this->settingsService->get('free_package');
        $type = "free-package";
        return view('setting::update', compact('settings', 'type'));
    }
    public function updateFreePackage(UpdateFreePackageRequest $request)
    {
        $settingsCollection = SettingsCollectionDTO::fromArray($request->validated());
        $this->settingsService->update('free_package', $settingsCollection);
        return \success_update('settings-ad-license.index');
    }
}
