<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TakamolatService
{

    public static function createRequest(string $licenceNumber, string $advertiserId, int $idType)
    {
        $link = \config('takamolat.mode') == 'sandbox' ? 'https://integration-gw.housingapps.sa/nhc/dev' : 'https://integration-gw.nhc.sa/nhc/prod';
        $response = Http::withHeaders([
            "X-IBM-Client-Id" => \config('takamolat.client_id'),
            "X-IBM-Client-Secret" => \config('takamolat.client_secret'),
        ])
            ->get($link . '/v1/brokerage/AdvertisementValidator?adLicenseNumber=' . $licenceNumber . '&advertiserId=' . $advertiserId . '&idType=' . $idType);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['Body']['success']) {
                return [
                    'success' => $data['Body']['result']['isValid'],
                    'message' => $data['Body']['result']['isValid'] ? 'تم التحقق من العقار بنجاح' : $data['Body']['result']['message'],
                ];
            } else
                return [
                    'success' => false,
                    'message' => $data['Body']['result']['message'],
                ];
        }
        // error
        if ($response->status() == 400) {
            $data = $response->json();
            return [
                'success' => false,
                'message' => $data['Body']['error']['message'],
            ];
        }
        return [
            'success' => false,
            'message' => __('messages.something_happened'),
        ];
    }
}