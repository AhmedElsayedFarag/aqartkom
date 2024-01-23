<?php

namespace Modules\Auth\Services;

use App\DataTransferObjects\QrcodeDto;
use App\Exceptions\InvalidOtpException;
use App\Exceptions\OldPasswordIsInvalidException;
use App\Exceptions\UserCredentialsAreWrong;
use App\Exceptions\UserIsBlocked;
use App\Services\MsegatService;
use App\Services\NafathService;
use Modules\Auth\Entities\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Modules\Auth\DataTransferObjects\ChangePasswordDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Entities\ChangePhoneOTP;
use Modules\Auth\Entities\VerificationCode;
use Modules\Auth\Http\Requests\Api\NafathLoginRequest;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Modules\Setting\Services\SettingsService;

class AuthService
{

    /**
     * Register new users.
     *
     * @return \Illuminate\Http\Response
     */
    public static function register(RegisterRequest $request)
    {
        $freeAds = 0;
        if ($request->get('type') == 'owner')
            $freeAds =  SettingsService::getSingle('free_package', 'ads-count')['value'];
        if ($request->get('type') == 'marketer')
            $freeAds =  SettingsService::getSingle('free_package', 'ads-marketer-count')['value'];
        if ($request->get('type') == 'company')
            $freeAds =  SettingsService::getSingle('free_package', 'ads-company-count')['value'];
        self::verifyOtp($request->get('phone'), $request->get('otp'));


        $request->merge([
            'password' => Hash::make($request->get('password')),
            // 'free_ads' => SettingsService::getSingle('free_package', 'ads-count')['value'],
            'free_ads' => $freeAds,
        ]);
        return DB::transaction(function () use ($request) {
            $data = $request->all();

            if ($request->file('profile')) {
                $data['profile'] = $request->file('profile')->store('', ['disk' => 'profile']);
            }
            $user = User::create($data);
            $user->phone_verified_at = now();
            $user->save();
            if ($request->get('type') == 'marketer') {
                $request->merge([
                    'whatsapp_number' => $request->get('phone'),
                    'qr_code' => \create_qr_code(new QrcodeDto(
                        route('front.marketer.show', ['marketer' => $user->uuid]),
                        'marketers'
                    ))
                ]);
                MarketerProfileService::create($request, $user);
            }
            if ($request->get('type') == 'company') {
                CompanyProfileService::create($request, $user);
            }
            $user->refresh();
            return $user;
        });
    }

    /**
     * Authenticate users.
     *
     * @param  Array  $credentials
     * @return Auth\Entities\User|Boolean User instance or false
     */
    public static function login($credentials, $mobileToken = null)
    {
        if (!Auth::attempt($credentials)) {
            throw new UserCredentialsAreWrong();
        }
        $user = Auth::user();

        if ($user->is_blocked) {
            auth()->logout();
            throw new UserIsBlocked();
        }

        if ($mobileToken) {
            // Revoke old token
            // $user = User::where('phone', $credentials['phone'])->first();
            $user->update(['mobile_token' => $mobileToken]);
        }
        $user->tokens()->where('name', 'access token')->delete();
        return $user;
    }

    /**
     * Revoke current user access token.
     *
     * @param  \Auth\Entities\User $user
     * @return Boolean
     */
    public static function logout(User $user)
    {
        $user->currentAccessToken()->delete();
        return true;
    }


    /**
     * Generate new otp for user.
     *
     * @param  Array $resetPasswordData
     * @return Boolean
     */
    public static function generateOtp($phone)
    {
        $verificationCode = VerificationCode::where('phone', $phone)->latest()->first();
        if ($verificationCode && now()->diffInSeconds($verificationCode->expire_at) < 30) {
            $verificationCode->phone = $phone;
            return $verificationCode;
        }
        if (config('app.is_dev')) {
            $code = 111111;
        } else {
            $code = rand(123456, 999999);
            // $code = 111111;
            MsegatService::sendOTP($phone, $code);
        }

        return VerificationCode::create([
            'phone' => $phone,
            // 'otp' => rand(123456, 999999),
            'otp' => $code,
            'expire_at' => now()->addMinutes(VerificationCode::EXPIRY)
        ]);
    }

    /**
     * Verify user otp.
     *
     * @param  Array $resetPasswordData
     * @return Boolean
     */
    public static function verifyOtp($phone, $otp)
    {
        $verificationCode = VerificationCode::select(['expire_at', 'id'])
            ->where([
                ['phone', $phone],
                ['otp', $otp]
            ])->latest('id')->first();

        if (!isset($verificationCode) || now()->isAfter($verificationCode->expire_at)) {
            throw new InvalidOtpException();
        }

        $verificationCode->delete();

        return true;
    }


    /**
     * Reset current user password.
     *
     * @param  Array $resetPasswordData
     * @return Boolean
     */
    public static function resetPassword($resetPasswordData)
    {
        $user = User::where('phone', $resetPasswordData['phone'])->first();
        if (self::verifyOtp($resetPasswordData['phone'], $resetPasswordData['code'])) {
            return $user->forceFill([
                'password' => Hash::make($resetPasswordData['password']),
                'remember_token' => Str::random(60),
            ])->save();
        }
        return false;
    }
    public static function changePassword(ChangePasswordDTO $changePasswordDto)
    {
        if (Hash::check(
            $changePasswordDto->oldPassword,
            $changePasswordDto->currentPassword
        )) {
            return auth()->user()->update([
                'password' => Hash::make($changePasswordDto->newPassword),
            ]);
        }
        throw new OldPasswordIsInvalidException();
    }
    public static function changeProfile(ChangeProfileDTO $changeProfileDTO)
    {
        auth()->user()->update($changeProfileDTO->toArray());
    }
    public static function changeProfileImage(ChangeProfileImageDTO $changeProfileImageDTO, Authenticatable $user)
    {

        $user->update([
            'profile' => \update_image([
                'oldLink'   => $changeProfileImageDTO->oldImage,
                'icon'      => $changeProfileImageDTO->image,
                'disk'      => 'profile',
            ]),
        ]);
    }
    public static function changePhoneNumber(string $phone)
    {
        $verificationCode = ChangePhoneOTP::where('phone', $phone)->latest()->first();
        if ($verificationCode && now()->isBefore($verificationCode->expire_at)) {
            $verificationCode->expire_at = now()->addMinutes(VerificationCode::EXPIRY);
            $verificationCode->save();
            return $verificationCode;
        }
        $code = rand(123456, 999999);
        // $code = 111111;

        $verificationCode = ChangePhoneOTP::create([
            'phone'         => $phone,
            'code'          => $code,
            'expire_at'     => now()->addMinutes(VerificationCode::EXPIRY),
            'user_id'       => auth()->id(),
        ]);
        MsegatService::sendOTP($phone, $code);
        return $verificationCode;
    }
    public static function verifyNewNumber(string $phone, string $code)
    {
        $verificationCode = ChangePhoneOTP::select(['expire_at', 'id', 'user_id'])
            ->where([
                ['phone', $phone],
                ['code', $code]
            ])->latest()->first();
        if (!isset($verificationCode) || now()->isAfter($verificationCode->expire_at)) {
            throw new InvalidOtpException();
        }
        $verificationCode->user()->update(['phone' => $phone]);
        $verificationCode->delete();
    }
    public static function verifyAccount(string $nationalNumber)
    {
        return NafathService::createRequest($nationalNumber);
        // auth()->user()->update(['is_authorized' => true]);
    }
    public static function loginByNafath(NafathLoginRequest $request)
    {
        return NafathService::createRequest($request->national_number, 'login', $request->mobile_token);
    }
}