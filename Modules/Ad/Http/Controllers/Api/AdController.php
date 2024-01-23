<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Helpers\FavoriteTrait;
use App\Helpers\JsonResponseMessages;
use App\Models\AdView;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;

use Modules\Ad\Http\Requests\AdReportRequest;
use Modules\Ad\Http\Requests\Api\AdMapFilterRequest;
use Modules\Ad\Http\Requests\Api\AdUserFilterRequest;
use Modules\Ad\Http\Requests\Api\AdVisitRequest;
use Modules\Ad\Services\AdService;
use Modules\Ad\Transformers\AdShowResource;
use Modules\Ad\Transformers\AdsResource;

class AdController extends Controller
{
    use FavoriteTrait;

    public function __construct(private AdService $adService)
    {
    }

    public function search()
    {
        return $this->adService->search()->limit(50)->get()->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->estate->title
            ];
        });
    }

    /**
     * Display a listing of ads
     * @return Renderable
     */
    public function index(AdUserFilterRequest $request)
    {
        return AdsResource::collection($this->adService->getAll()->paginate(800));
    }

    public function getMapAds(AdMapFilterRequest $request)
    {
        return AdsResource::collection($this->adService->getMapAds()->paginate(800));
    }

    /**
     * Display a listing of ad marketing
     * @return Renderable
     */
    public function AdMarketing(AdUserFilterRequest $request)
    {
        \abort_if(auth()->user()->type != 'marketer', 422, __('messages.you_are_not_marketer'));
        return AdsResource::collection($this->adService->getAllAdMarketing()->paginate(100));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Ad $ad)
    {
        $ip = request()->header('x-real-ip');
        if ($ip) {
            $adView = AdView::where('ad_id', $ad->id)->where('ip', $ip)->first();
            if (!$adView) {
                AdView::create([
                    'ad_id' => $ad->id,
                    'ip' => $ip
                ]);
            }
        }
        $ad->views++;
        $ad->save();
        $this->adService->loadRelations($ad);
        $ad->is_favorite = $this->addIsFavorite($ad->id, Ad::class);
        return new AdShowResource($ad);
    }

    public function visit(AdVisitRequest $request, Ad $ad)
    {
        $ad->visits()->create($request->validated());
        return JsonResponseMessages::created();
    }

    public function report(AdReportRequest $request, Ad $ad)
    {
        $ad->reports()->create($request->validated());
        return JsonResponseMessages::created();
    }
}