<?php

namespace Modules\Auth\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\Front\ResetPasswordRequest;
use Modules\Auth\Services\AuthService;

class ResetPasswordController extends Controller
{


    public function showForm()
    {
        if (!session()->has('phone'))
            return redirect()->to(route('front.index'));
        $phone = session()->get('phone');
        return view('auth::front-end.reset-password', compact('phone'));
    }
    public function store(ResetPasswordRequest $request)
    {

        AuthService::resetPassword($request->validated());
        return redirect()->route('front.login');
    }
}