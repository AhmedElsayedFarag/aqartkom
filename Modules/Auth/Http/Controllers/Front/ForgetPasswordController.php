<?php

namespace Modules\Auth\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\Front\ForgetPasswordRequest;
use Modules\Auth\Services\AuthService;

class ForgetPasswordController extends Controller
{

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function __invoke(ForgetPasswordRequest $request)
    {
        AuthService::generateOtp($request->phone);
        \session(['phone' => $request->phone]);
        return redirect()->to(route('front.reset-password'));
    }
}