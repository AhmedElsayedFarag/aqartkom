<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Http\Requests\Api\LoginRequest;
use Modules\Auth\Http\Requests\Api\NafathLoginRequest;
use Modules\Auth\Transformers\AuthUserResource;

class AuthenticatedTokenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(LoginRequest $request)
    {

        return new AuthUserResource(AuthService::login($request->credentials(), $request->mobile_token));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function logout(Request $request)
    {
        return AuthService::logout($request->user()) ? response()->noContent() : abort(400);
    }
    public function destroy()
    {
        auth()->user()->delete();
        return JsonResponseMessages::deleted();
    }
    public function loginByNafath(NafathLoginRequest $request)
    {
        return AuthService::loginByNafath($request);
    }
}
