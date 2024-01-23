<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Transformers\OtpResource;
use Modules\Auth\Http\Requests\Api\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function __invoke(ForgotPasswordRequest $request)
    {

        $otp = AuthService::generateOtp($request->phone);
        // Send OTP SMS
        return new OtpResource($otp);
    }
}
