<?php

namespace Modules\Users\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\AdFilter;
use Modules\Ad\Http\Requests\Front\AdFilterRequest;
use Modules\Ad\Services\AdService;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Category\Services\CategoriesService;
use Modules\City\Services\CitiesService;
use Modules\Users\Services\CompaniesService;
use Modules\Users\Services\UsersService;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $companiesService = new CompaniesService();
        $companies = $companiesService->getAll();
        return view('users::front.companies', \compact('companies'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(AdFilterRequest $request, CompanyProfile $company)
    {

        $company->load(['user' => fn ($query) => $query->select(['id', 'name', 'phone', 'type', 'profile'])]);
        // $adService = new AdService();
        // $ads = $adService->getUserAds($company->user_id, 'approved');
        $categories = CategoriesService::getAll();
        $filters = AdFilter::select(['name', 'group', 'values'])->get()->groupBy('group')->toArray();
        $cities = CitiesService::getAll();
        // foreach ($ads->items() as $ad) {
        //     $ad->owner = $company->user;
        // }
        return view('users::front.company-ads', \compact('company', 'categories', 'filters', 'cities'));
    }
}
