<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Transformers\AuthUserResource;
use Modules\Auth\Http\Requests\Api\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function __invoke(ResetPasswordRequest $request)
    {

        if ($reset = AuthService::resetPassword($request->validated())) {
            $user = User::where('phone', $request->phone)->first();
            return new AuthUserResource($user);
        }
        abort_unless($reset, 400);
    }
}
