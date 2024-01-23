<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\DataTransferObject\AdRequestDto;
use Modules\Ad\Entities\AdRequest;
use Modules\Ad\Http\Requests\Api\AdFilterRequest;
use Modules\Ad\Http\Requests\Api\AdRequestRequest;
use Modules\Ad\Services\AdRequestService;
use Modules\Ad\Transformers\User\AdRequestShowResource;
use Modules\Estate\DataTransferObject\EstateDto;

class AdRequestUserController extends Controller
{

    public function __construct(private AdRequestService $requestService)
    {
        $this->middleware('not_authorized')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(AdFilterRequest $request)
    {

        return AdRequestShowResource::collection(
            $this->requestService
                ->getUserAds(auth()->id(), $request->get('status'))
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdRequestRequest $request)
    {
        // \abort_if(auth()->user()->type != 'customer', 422, __('messages.user_is_not_allowed_to_add_ad'));
        $adDto = new AdRequestDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad_request'],
            $request->get('details') ?? [],
            [],
        );
        $ad = $this->requestService->createOrUpdate($adDto, $estateDto);
        return new AdRequestShowResource($ad);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(AdRequest $ad_request)
    {
        $this->requestService->isAdOwner($ad_request);
        $ad_request->load([
            ...$this->requestService->getRelations(),
            'estate.details.attribute.values' => fn ($query) => $query->select(['id', 'estate_attribute_id', 'value'])
        ]);
        return new AdRequestShowResource($ad_request);
    }

    public function addFeature(AdRequest $ad_request)
    {
        return  DB::transaction(function () use ($ad_request) {
            $this->requestService->isAdOwner($ad_request);
            $this->requestService->isFeatured($ad_request);
            $transaction = $this->requestService->addFeature($ad_request);
            return response()->json([
                'url' => route('transaction.callback', ['id' => $transaction->uuid,])
            ]);
        });
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdRequestRequest $request, AdRequest $ad_request)
    {
        \abort_if($ad_request->user_id != auth()->id(), 404);
        // estate media =>10 | deleted_media = 10 | new media =2
        // $estateMediaCount = EstateMedia::where('estate_id', $ad->estate_id)->count();
        // $newMediaCount = count($request->get('media') ?? []);
        // if ($estateMediaCount + $newMediaCount < 2) {
        //     throw new AdMediaMustBeAddedException();
        // }
        $adDto = new AdRequestDto(
            $request->get('type'),
            $request->get('price'),
            auth()->user(),
        );
        $estateDto = new EstateDto(
            [...$request->get('estate'), 'type' => 'ad'],
            $request->get('details') ?? [],
            []
        );
        $ad = $this->requestService->createOrUpdate($adDto, $estateDto, $ad_request);
        return new AdRequestShowResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AdRequest $ad_request)
    {
        $this->requestService->isAdOwner($ad_request);

        $ad_request->delete();
        return JsonResponseMessages::deleted();
    }

    // public function active(AdRequest $ad_request)
    // {
    //     $this->requestService->isAdOwner($ad_request);
    //     $this->requestService->active($ad_request);
    //     return JsonResponseMessages::updated();
    // }

    // public function unactive(AdRequest $ad_request)
    // {
    //     $this->requestService->isAdOwner($ad_request);
    //     $this->requestService->unactive($ad_request);
    //     return JsonResponseMessages::updated();
    // }

    // public function refresh(AdRequest $ad_request)
    // {
    //     if ($ad_request->status == 'approved')
    //         $ad_request->update(['accepted_at' => now()->toDateTimeString()]);
    //     return JsonResponseMessages::updated();
    // }
}