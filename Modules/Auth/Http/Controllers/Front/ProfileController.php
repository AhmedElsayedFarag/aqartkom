<?php

namespace Modules\Auth\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\Ad;
use Modules\Auth\DataTransferObjects\ChangePasswordDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileDTO;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Http\Requests\Admin\UpdatePasswordRequest;
use Modules\Auth\Http\Requests\Api\ChangePhoneRequest;
use Modules\Auth\Http\Requests\Api\VerifyNewPhoneRequest;
use Modules\Auth\Http\Requests\Front\UpdateCompanyProfileRequest;
use Modules\Auth\Http\Requests\Front\UpdateProfileRequest;
use Modules\Auth\Services\AuthService;
use Modules\City\Entities\City;
use Modules\Package\Entities\AdFeaturePackage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function ads()
    {
        $packages = AdFeaturePackage::query()->where('type', auth()->user()->type)->get();
        return view('auth::front-end.profile.my-ads', compact('packages'));
    }
    public function marketRequest()
    {
        return view('auth::front-end.profile.market-requests');
    }
    public function licenceRequest()
    {
        return view('auth::front-end.profile.licence-requests');
    }
    public function licenceRequestState(Ad $ad)
    {
        return view('auth::front-end.profile.licence-request-state', ['ad' => $ad]);
    }
    public function bids()
    {
        return view('auth::front-end.profile.my-bids');
    }
    public function showChangeDataForm()
    {
        return \view('auth::front-end.profile.change-data');
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $changeDto = new ChangeProfileDTO($request->get('name'), $request->get('email'));
        AuthService::changeProfile($changeDto);
        if ($request->has('image')) {
            $changeProfileImageDto = new ChangeProfileImageDTO($request->file('image'), auth()->user()->profile);
            AuthService::changeProfileImage($changeProfileImageDto, auth()->user());
        }
        if (auth()->user()->type == 'marketer') {
            $marketer = auth()->user()->marketerProfile;
            $marketer->update($request->except(['_token', 'image']));
        }
        return \redirect_response('success', __('messages.success_update'), 'front.change-data.show');
    }
    public function showChangePasswordForm()
    {
        return \view('auth::front-end.profile.change-password');
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $changePasswordDto = new ChangePasswordDTO(
            $request->get('old_password'),
            $request->get('password'),
            auth()->user()->password,
        );
        AuthService::changePassword($changePasswordDto);
        return \redirect_response('success', __('messages.success_update'), 'front.change-password.show');
    }
    public function showChangePhoneForm()
    {
        return \view('auth::front-end.profile.change-phone');
    }
    public function changePhone(ChangePhoneRequest $request)
    {
        $phone = $request->phone;
        $code = (string)AuthService::changePhoneNumber($phone)->code;
        session()->put('phone', $phone);
        session()->put('code', $code);
        return redirect()->to(route('front.verify-phone.show'));
    }
    public function showVerifyPhoneForm()
    {
        $code = session()->get('code');
        $phone = session()->get('phone');
        return view('auth::front-end.verify', compact('code', 'phone'));
    }
    public function verifyPhone(VerifyNewPhoneRequest $request)
    {
        AuthService::verifyNewNumber($request->phone, $request->code);
        return redirect()->to(route('front.index'));
    }
    public function favorites()
    {
        return view('auth::front-end.profile.favorite');
    }
    public function showCompanyProfileForm()
    {
        $cities = City::select(['id', 'name'])->get();
        $company = auth()->user()->companyProfile;
        return view('auth::front-end.profile.company-profile', compact('company', 'cities'));
    }
    public function updateCompanyProfile(UpdateCompanyProfileRequest $request)
    {
        $request->merge(['whatsapp_number' => $request->get('whatsapp')]);
        auth()->user()->companyProfile()->update($request->except(['_token', 'whatsapp']));
        return redirect()->route('front.company-profile.show');
    }
}