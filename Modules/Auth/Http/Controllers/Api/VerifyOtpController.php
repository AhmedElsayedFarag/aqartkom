<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Http\Requests\Api\VerifyOtpRequest;

class VerifyOtpController extends Controller
{
  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function __invoke(VerifyOtpRequest $request)
  {
    return AuthService::verifyOtp($request->user(), $request->otp);
  }
}
