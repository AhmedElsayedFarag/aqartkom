<?php

namespace Modules\Auth\Http\Controllers\Api;

use Modules\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Transformers\AuthUserResource;
use Modules\Auth\Http\Requests\Api\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Store a newly created resource in storage.

     * @return Response
     */
    public function __invoke(RegisterRequest $request)
    {
        return new AuthUserResource(AuthService::register($request));
    }
}
