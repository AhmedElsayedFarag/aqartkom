<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\DataTransferObjects\ChangePasswordDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Http\Requests\Api\UpdatePasswordRequest;
use Modules\Auth\Http\Requests\Api\UpdateProfileImageRequest;
use Modules\Auth\Http\Requests\Api\UpdateProfileRequest;
use Modules\Auth\Http\Requests\Api\ChangePhoneRequest;
use Modules\Auth\Http\Requests\Api\VerifyNewPhoneRequest;
use Modules\Auth\Http\Requests\VerifyAccountRequest;
use Modules\Auth\Services\AuthService;

class ProfileController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $changePasswordDto = new ChangePasswordDTO(
            $request->get('old'),
            $request->get('password'),
            auth()->user()->password,
        );
        AuthService::changePassword($changePasswordDto);
        return JsonResponseMessages::updated();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $changeProfileDto = new ChangeProfileDTO(
            $request->get('name'),
            $request->get('email')
        );
        AuthService::changeProfile($changeProfileDto);
        if (auth()->user()->type == 'marketer')
            auth()->user()->marketerProfile->update($request->only('advertisement_number'));
        return JsonResponseMessages::updated();
    }
    public function updateProfileImage(UpdateProfileImageRequest $request)
    {
        $changeProfileImage = new ChangeProfileImageDTO(
            $request->file('image'),
            auth()->user()->profile
        );
        AuthService::changeProfileImage($changeProfileImage, auth()->user());
        return JsonResponseMessages::updated();
    }
    public function updatePhone(ChangePhoneRequest $request)
    {
        return response()->json([
            'code' => (string)AuthService::changePhoneNumber($request->phone)->code,
        ]);
    }
    public function verifyNewNumber(VerifyNewPhoneRequest $request)
    {
        AuthService::verifyNewNumber($request->phone, $request->code);
        return JsonResponseMessages::updated();
    }
    public function verifyAccount(VerifyAccountRequest $request)
    {
        auth()->user()->update(['nationality_id' => $request->national_number]);
        return AuthService::verifyAccount($request->national_number);
        // return JsonResponseMessages::updated();
    }
}