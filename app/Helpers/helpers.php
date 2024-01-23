<?php

use App\DataTransferObjects\QrcodeDto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;
use Modules\Setting\Services\SettingsService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (!function_exists('current_locale')) {
    function current_locale()
    {
        return App::getLocale();
    }
}

if (!function_exists('upload_image')) {
    function upload_image(UploadedFile $image, string $disk)
    {
        return "storage/$disk/" . $image->store('', ['disk' => $disk]);
    }
}

if (!function_exists('delete_file')) {
    function delete_file(string $link)
    {
        if (file_exists($link) && !str_contains($link, 'default'))
            unlink($link);
    }
}

if (!function_exists('update_image')) {
    function update_image(array $config)
    {
        delete_file($config['oldLink']);
        return upload_image($config['icon'], $config['disk'], isset($config['uuid']) ? $config['uuid'] : null);
    }
}

if (!function_exists('success_add')) {
    function success_add(string $route, array $params = [])
    {

        return redirect_response('success', __('messages.added_successfully'), "dashboard.$route", $params);
    }
}
if (!function_exists('success_update')) {
    function success_update(string $route, array $params = [])
    {

        return redirect_response('success', __('messages.success_update'), "dashboard.$route", $params);
    }
}
if (!function_exists('success_delete')) {
    function success_delete(string $route, array $params = [])
    {

        return redirect_response('success', __('messages.success_delete'), "dashboard.$route", $params);
    }
}

if (!function_exists('error_response')) {
    function error_response(string $message, string $route)
    {
        return redirect_response('danger', $message, $route);
    }
}

if (!function_exists('redirect_response')) {
    function redirect_response($type, $message, $route, array $params = [])
    {
        session()->flash($type, $message);
        return redirect()->route($route, $params)
            ->with('type', $type)->with('message', $message);
    }
}

if (!function_exists('is_available_subscription')) {
    function is_available_subscription()
    {
        return Session::get('is_subscription_available');
    }
}
if (!function_exists('get_gender')) {
    function get_gender()
    {
        return auth('sanctum')?->user()?->gender ?? request()->header('gender');
    }
}
if (!function_exists('arabic_date')) {

    function arabic_date($date)
    {

        $months = array("Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر");
        $en_month = date("M", strtotime($date));
        foreach ($months as $en => $ar) {
            if ($en == $en_month) {
                $ar_month = $ar;
            }
        }

        $find = array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri");
        $replace = array("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
        $ar_day_format = date('D', strtotime($date)); // The Current Day
        $ar_day = str_replace($find, $replace, $ar_day_format);

        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
        $current_date = $ar_day . ' ' . date('d', strtotime($date)) . '  ' . $ar_month . '  ' . date('Y', strtotime($date));
        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

        return $arabic_date;
    }
}
if (!function_exists('get_arabic_number')) {
    function get_arabic_number($number)
    {
        $result = '';
        $array = str_split($number);
        $numbers = [
            "0" => "٠",
            "1" => "١",
            "2" => "٢",
            "3" => "٣",
            "4" => "٤",
            "5" => "٥",
            "6" => "٦",
            "7" => "٧",
            "8" => "٨",
            "9" => "٩",
        ];
        foreach ($array as $value) {
            $result .= $numbers[$value];
        }
        return $result;
    }
}

if (!function_exists('generate_coordination')) {
    function generate_coordination(float $min, float $max, int $places = 6)
    {
        $places = pow(10, $places);
        $min *= $places;
        $max *= $places;
        return rand($min, $max) / $places;
    }
}

if (!function_exists('generate_uuid')) {
    function generate_uuid(string $model)
    {
        $uuid = "";
        do {
            $uuid = Str::uuid();
        } while ($model::firstWhere("uuid", $uuid));
        return $uuid;
    }
}
if (!function_exists('get_contact_number')) {
    function get_contact_number(?User $user = null)
    {
        if (is_null($user))
            return ' ';
        if (!auth('sanctum')->check() && request()->is('api/*'))
            return ' ';
        // if ($user->type == 'customer' || $user->type == 'admin') {
        if ($user->type == 'admin') {
            return SettingsService::getContactPhone();
        }
        return $user->phone;
    }
}
if (!function_exists('get_owner_name')) {
    function get_owner_name(User $user)
    {
        // if ($user->type == 'customer' || $user->type == 'admin') {
        if ($user->type == 'admin') {
            return "ادارة عقاراتكم";
        }
        return $user->name;
    }
}
if (!function_exists('get_whatsapp_number')) {
    function get_whatsapp_number($user)
    {
        if (is_null($user))
            return '';
        if (!auth('sanctum')->check() && request()->is('api/*'))
            return ' ';
        // if ($user->type == 'customer' || $user->type == 'admin') {
        if ($user->type == 'admin') {
            return SettingsService::getContactPhone();
        }
        if ($user->type == 'company')
            return $user->companyProfile()->select(['user_id', 'whatsapp_number'])->first()->whatsapp_number;
        if ($user->type == 'marketer')
            return $user->marketerProfile()->select(['user_id', 'whatsapp_number'])->first()->whatsapp_number;
        return $user->phone;
    }
}

if (!function_exists('update_api_response')) {
    function update_api_response()
    {
        return response()->json([
            'message' => __('messages.success_update'),
        ]);
    }
}

if (!function_exists('getDistanceBetweenPoints')) {
    function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        // $feet = $miles * 5280;
        // $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        // $meters = $kilometers * 1000;
        return $kilometers;
    }
}
if (!function_exists('module_path')) {
    function module_path($name, $path = '')
    {
        return app()->basePath() . DIRECTORY_SEPARATOR . 'Modules' . DIRECTORY_SEPARATOR . $name .  $path;
    }
}

if (!function_exists('create_qr_code')) {

    function create_qr_code(QrcodeDto $dto)
    {
        $image = QrCode::format('png')
            ->size(200)
            ->generate($dto->route);
        $qrcode = Str::random(40) . '.png';
        Storage::disk($dto->disk)->put($qrcode, $image);
        return $qrcode;
    }
}
if (!function_exists('format_mortgages_features')) {
    function format_mortgages_features($data)
    {

        $features = [];
        foreach ($data as $key => $value) {
            $features[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return $features;
    }
}