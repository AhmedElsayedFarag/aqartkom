<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Transformers\OtpResource;
use Modules\Auth\Http\Requests\Api\GenerateOtpRequest;

class GenerateOtpController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    public function __invoke(GenerateOtpRequest $request)
    {
        $otp = AuthService::generateOtp($request->phone);
        //    Send OTP via sms

        return new OtpResource($otp);
    }
}
