<?php

namespace App\Services;

use App\DataTransferObjects\FCMDTO;
use App\Events\LoginEvent;
use App\Events\VerifyEvent;
use App\Helpers\FCMHelper;
use App\Models\Nafath;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User;

class NafathService
{

    public static function createRequest(string $nationalID, string $type = 'verify', ?string $mobileToken = null)
    {

        $requestID = Str::uuid()->toString();
        if ($type == 'verify')
            $userID = auth()->id();
        else {
            $user = User::query()->where('nationality_id', $nationalID)->first();
            if (is_null($user)) {
                return response()->json(['message' => __('messages.something_happened')], 422);
            }
            $userID = $user->id;
        }
        $nafath = Nafath::create([
            "requestId" => $requestID,
            "nationalId" => $nationalID,
            'data' => json_encode([]),
            'user_id' => $userID,
            'type' => $type,
            'mobile_token' => $mobileToken,
            'source' => request()->get('source', 'mobile'),
        ]);
        $link = config('nafath.mode') == 'stg' ? 'https://nafath.api.elm.sa/stg/' : 'https://nafath.api.elm.sa/';
        $response = Http::withHeaders([
            'APP-ID' => config('nafath.id'),
            'APP-KEY' => config('nafath.secret'),
        ])->post($link . 'api/v1/mfa/request?local=ar&requestId=' . $requestID, [
            "nationalId" => $nationalID,
            "service" => "RecipientApprovalWithoutBio",
        ]);
        if ($response->successful()) {
            $nafath->update([
                'data' => json_encode($response->json()),
                'random' => $response->json()['random'],
                'transId' => $response->json()['transId'],
            ]);
            return response()->json([
                'random' => $response->json()['random'],
            ]);
        }
        if ($response->clientError()) {
            $nafath->update([
                'data' => json_encode($response->json()),
            ]);
            return response()->json(['message' => __('messages.something_happened')], 422);
        }
        return response()->json(['message' => __('messages.something_happened')], 422);
    }
    public static function checkStatus(string $requestId, string $transID)
    {
        $nafath = Nafath::query()->where('requestId', $requestId)->where('transId', $transID)->latest('id')->first();

        if (is_null($nafath)) {
            return response()->json(['message' => __('messages.something_happened')], 422);
        }
        $link = config('nafath.mode') == 'stg' ? 'https://nafath.api.elm.sa/stg/' : 'https://nafath.api.elm.sa/';
        $response = Http::withHeaders([
            'APP-ID' => config('nafath.id'),
            'APP-KEY' => config('nafath.secret'),
        ])->post($link . 'api/v1/mfa/request/status', [
            "nationalId" => $nafath->nationalId,
            "transId" => $transID,
            "random" => $nafath->random
        ]);
        if (!$response->successful()) {
            return;
        }
        if ($response->json()['status'] != 'COMPLETED')
            return;
        if ($nafath->type == 'verify') {
            $user = User::query()->where('id', $nafath->user_id)->first();
            $user->update(['is_authorized' => true]);
            if ($nafath->source == 'web')
                event(new VerifyEvent($nafath->user_id));
            if ($nafath->source == 'mobile') {
                $dto = new FCMDTO('تم تفعيل حسابك بنجاح', 'تم تفعيل حسابك بنجاح',  $nafath->mobile_token);
                $dto->addData('type', 'verify')
                    ->isHidden();
                FCMHelper::sendMessage($dto);
            }
            return;
        }
        if ($nafath->type == 'login') {
            $user = Auth::loginUsingId($nafath->user_id);
            if ($nafath->source == 'mobile') {
                $token = $user->createToken('access token')->plainTextToken;
                $dto = new FCMDTO('تم دخول حسابك بنجاح', 'تم دخول حسابك بنجاح',  $nafath->mobile_token);
                $dto->addData('login', 'login')
                    ->addData('token', $token)
                    ->addData('user_type', $user->type)
                    ->isHidden();
                FCMHelper::sendMessage($dto);
            }
            if ($nafath->source == 'web') {
                $randString = Str::random(10);
                $user->update(['one_time_login' => $randString]);
                event(new LoginEvent($nafath->nationalId, $randString));
            }
        }
        //send fcm notification by mobile token
        // return response()->json(['message' => __('messages.something_happened')], 422);
    }
}
