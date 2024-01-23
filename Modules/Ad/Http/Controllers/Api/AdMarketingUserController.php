<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Exceptions\AdMediaMustBeAddedException;
use App\Helpers\JsonResponseMessages;
use App\Services\TakamolatService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ad\DataTransferObject\AdDto;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdMarketingLicenseRequest;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Http\Requests\Api\AdRequest;
use Modules\Ad\Http\Requests\Api\AdUpdateRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdShowResource;
use Modules\Ad\Transformers\User\AdsResource;
use Modules\Estate\DataTransferObject\EstateDto;
use Modules\Estate\Entities\EstateMedia;


class AdMarketingUserController extends Controller
{
    public function __construct(private AdService $adService)
    {
        $this->middleware('not_authorized')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(AdFilterRequest $request)
    {

        return AdsResource::collection(
            $this->adService
                ->getUserAdMarketing(auth()->id(), $request->get('status'))
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdRequest $request)
    {
        // \abort_if(auth()->user()->type == 'customer', 422, __('messages.user_is_not_allowed_to_add_ad'));
        $adDto = new AdDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user()
        );
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media'),
        );
        $ad = $this->adService->createOrUpdateAdMarket($adDto, $estateDto);
        return new AdShowResource($ad);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        \abort_if($ad->user_id != auth()->id(), 404);
        // estate media =>10 | deleted_media = 10 | new media =2
        $estateMediaCount = EstateMedia::where('estate_id', $ad->estate_id)->count();
        $newMediaCount = count($request->get('media') ?? []);
        if ($estateMediaCount + $newMediaCount < 2) {
            throw new AdMediaMustBeAddedException();
        }
        $adDto = new AdDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            $request->get('media') ?? []
        );
        $ad = $this->adService->createOrUpdateAdMarket($adDto, $estateDto, $ad);
        return new AdShowResource($ad);
    }
    public function addLicenseNumber(AdMarketingLicenseRequest $request, Ad $ad)
    {
        //validate with api of ministry of housing
        \abort_if($ad->user_id != auth()->id(), 404);
        // abort_if(!$ad->is_request, 422, __('messages.is_not_marketing_request'));

        $result = TakamolatService::createRequest(
            $request->license_number,
            $request->nationality_number,
            $request->nationality_type == 'marketer' ? 1 : 2
        );
        if ($result['success']) {
            $ad->update([
                'license_number' => $request->get('license_number'),
                'is_licensed' => true,
                'is_request' => false,
            ]);
            return JsonResponseMessages::updated();
        } else {
            return \response()->json([
                'message' => $result['message']
            ]);
        }
    }
}
