<?php

namespace Modules\Ad\Http\Controllers\Api;

use App\Helpers\FavoriteTrait;
use App\Helpers\JsonResponseMessages;
use App\Models\AdView;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\AdRequest;
use Modules\Ad\Http\Requests\Api\AdStoreRequest;
use Modules\Ad\Services\AdRequestService;
use Modules\Ad\Services\AdTypesService;
use Modules\Ad\Transformers\AdRequestShowResource;
use Modules\Ad\Transformers\AdRequestsResource;

class AdRequestController extends Controller
{
    public function __construct(private AdRequestService $requestService)
    {
    }
    public function search()
    {
        return $this->requestService->search()->limit(50)->get()->map(function ($request) {
            return [
                'id' => $request->id,
                'title' => $request->estate->title
            ];
        });
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return AdRequestsResource::collection($this->requestService->getAll()->paginate(300));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(AdRequest $request)
    {
        $this->requestService->loadRelations($request);

        return new AdRequestShowResource($request);
    }
}
