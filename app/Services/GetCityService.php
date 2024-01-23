<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Modules\City\Entities\City;
use Modules\Setting\Services\SettingsService;

class GetCityService
{

    public static function handle(
        ?float $lat = null,
        ?float $lng = null,
        ?int $cityId = null
    ): City {
        if (!is_null($lat) && !is_null($lng)) {

            return static::getCityByGoogleApi($lat, $lng);
        }
        if (!is_null($cityId)) {
            return City::select(['id', 'lat', 'long', 'name'])->where('id', $cityId)->first();
        }
        return static::getDefaultCity();
    }
    private static function getDefaultCity()
    {
        return
            City::select(['id', 'lat', 'long', 'name'])->where('name', "الرياض")->first();;
    }
    public static function getCityByGoogleApi(float $lat, float $lng)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "$lat,$lng",
            'key' => SettingsService::getMapApi(),
            'language' => 'ar'
        ])->json();
        $status = $response['status']; //OK

        if ($status != 'OK') {
            return static::getDefaultCity();
        }
        $addresses = $response['results'][0]['address_components'];
        $cityName = '';
        $secondCityName = '';
        foreach ($addresses as $address) {
            if (
                in_array('administrative_area_level_2', $address['types']) &&
                in_array('political', $address['types'])
            ) {
                $cityName = $address['long_name'];
                break;
            }
            if (
                in_array('locality', $address['types']) &&
                in_array('political', $address['types'])
            ) {
                $secondCityName = $address['long_name'];
                break;
            }
        }
        if (strlen($cityName)) {
            $city = City::firstWhere('name', 'like', "%$cityName%");
            return is_null($city) ? static::getDefaultCity() : $city;
        } else if (strlen($secondCityName)) {
            $city = City::firstWhere('name', 'like', "%$secondCityName%");
            return is_null($city) ? static::getDefaultCity() : $city;
        } else {
            return static::getDefaultCity();
        }
    }
}
