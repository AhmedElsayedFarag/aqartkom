<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Modules\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Http\Requests\Api\CompanyRequest;
use Modules\Auth\Transformers\AuthUserResource;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Modules\Auth\Http\Requests\Api\UpdateCompanyRequest;
use Modules\Auth\Services\CompanyProfileService;
use Modules\Users\Transformers\CompanyShowResource;

class CompanyProfileController extends Controller
{
    public function store(CompanyRequest $request)
    {
        if (auth()->user()->type !== 'customer')
            abort(404);
        CompanyProfileService::create($request, auth()->user());
        return JsonResponseMessages::created();
    }
    public function show()
    {
        if (auth()->user()->type !== 'company')
            abort(404);
        return new CompanyShowResource(auth()->user()->companyProfile);
    }
    public function update(UpdateCompanyRequest $request)
    {
        if (auth()->user()->type !== 'company')
            abort(404);
        CompanyProfileService::update($request, auth()->user()->companyProfile);
        return JsonResponseMessages::updated();
    }
}
