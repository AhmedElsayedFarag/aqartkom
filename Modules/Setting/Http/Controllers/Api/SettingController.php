<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Services\SettingsService;
use Modules\Setting\Transformers\SettingResource;

class SettingController extends Controller
{
    public function __invoke()
    {
        $settingsService = new SettingsService();
        $contactUsSettings = $settingsService->get('contact-us');
        $auctionSettings = $settingsService->get('auction');
        $settings = [
            ...$contactUsSettings, ...$auctionSettings
        ];
        $formattedSettings = [];

        foreach ($settings as $setting) {
            if ($setting['key'] == 'auction_document')
                $formattedSettings[$setting['key']] = asset($setting['value']);
            else
                $formattedSettings[$setting['key']] = $setting['value'];
        }
        $formattedSettings['indicators'] = 'https://www.aqarsas.com/indicators';
        $formattedSettings['show_companies'] = true;
        // $formattedSettings['indicators'] = '';
        return response()->json($formattedSettings);
    }
}