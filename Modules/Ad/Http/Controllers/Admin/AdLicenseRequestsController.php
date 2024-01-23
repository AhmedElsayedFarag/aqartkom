<?php

namespace Modules\Ad\Http\Controllers\Admin;

use App\DataTransferObjects\CoordinateDto;
use App\Services\TakamolatService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdFilterRequest;
use Modules\Ad\Http\Requests\AdStoreRequest;
use Modules\Ad\Http\Requests\AdUpdateRequest;
use Modules\Ad\Http\Requests\AdVerifyRequest;
use Modules\Ad\Services\AdService;
use Modules\Category\Entities\Category;
use Modules\City\Entities\City;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Services\EstateService;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;

class AdLicenseRequestsController extends Controller
{
    /**
     * filter by status
     * filter by search
     * filter by city
     * page for pending ads
     */
    public function __construct(
        private MediaService $mediaService,
        private AdService $adService,
    ) {
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function completed(AdFilterRequest $request)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        $ads = $this->adService->getAdminLicenseRequestsAll(true)->paginate(15)->withQueryString();
        return view('ad::ads.license_requests', compact('ads', 'categories', 'cities'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function pending(AdFilterRequest $request)
    {
        $categories = Category::select(['id', 'name'])->get();
        $cities = City::select(['id', 'name'])->get();
        $ads = $this->adService->getAdminLicenseRequestsAll(false)->paginate(15)->withQueryString();
        return view('ad::ads.license_requests', compact('ads', 'categories', 'cities'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function verify(Ad $ad)
    {
        $model = $ad;
        return view('ad::ads.verify', compact('model'));
    }



    public function verifyAd(AdVerifyRequest $request, Ad $ad)
    {
        // to be used after credentials is added
        $service = TakamolatService::createRequest(
            $request->licenceNumber,
            $request->advertiserId,
            $request->idType == 'marketer' ? 1 : 2
        );

        if ($service['success']) {
            $ad->update([
                'is_licensed' => 1,
                'license_number' => $request->licenceNumber,
            ]);
            return success_update('ad.index');
        }
        return redirect()->back()->with('error', $service['message']);
    }
}