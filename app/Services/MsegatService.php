<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MsegatService
{

    public static function sendSMS(string $phone, string $message)
    {

        return Http::post("https://www.msegat.com/gw/sendsms.php", [
            "userName" => config('msegat.user_name'),
            "numbers" => str_replace('+', '', $phone),
            "userSender" => config('msegat.sender_name'),
            "apiKey" => config('msegat.api_key'),
            "msg" => $message
        ])->json();
    }
    public static function sendOTP(string $phone, string $code)
    {
        return static::sendSMS($phone, "Pin Code is: " . $code)['code'] == 1;
    }
}
