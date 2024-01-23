<?php

namespace Modules\Users\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdsResource;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Users\Http\Requests\CompanyFilterRequest;
use Modules\Users\Services\CompaniesService;
use Modules\Users\Transformers\CompaniesResource;
use Modules\Users\Transformers\CompanyShowResource;

class CompaniesController extends Controller
{
    public function __construct(protected CompaniesService $companiesService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(CompanyFilterRequest $request)
    {
        //add city filter request and search text using inner join
        return CompaniesResource::collection($this->companiesService->getAll());
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(CompanyProfile $company)
    {
        $company->load(['user' => fn ($query) => $query->select(['id', 'phone', 'name', 'is_authorized', 'is_featured'])]);
        return new CompanyShowResource($company);
    }
    public function ads($company)
    {
        //add phone number without the need to load owner relationship
        $company = CompanyProfile::select(['user_id'])
            ->with(['user' => fn ($query) => $query->select(['id', 'name', 'phone', 'type', 'is_authorized', 'is_featured'])])
            ->where('uuid', $company)
            ->firstOrFail();
        $adService = new AdService();
        $ads = $adService->getUserAds($company->user_id, 'approved');

        foreach ($ads->items() as $ad) {
            $ad->owner = $company->user;
        }
        return AdsResource::collection($ads);
    }
}
