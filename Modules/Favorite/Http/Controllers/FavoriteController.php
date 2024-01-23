<?php

namespace Modules\Favorite\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Favorite\Http\Requests\FavoriteRequest;
use Modules\Favorite\Http\Requests\FavoriteToggleRequest;
use Modules\Favorite\Services\FavoriteAdService;
use Modules\Favorite\Services\FavoriteAuctionService;
use Modules\Favorite\Services\FavoriteCompanyService;
use Modules\Favorite\Services\FavoriteService;

class FavoriteController extends Controller
{
    private array $services = [
        'ad' => FavoriteAdService::class,
        'auction' => FavoriteAuctionService::class,
        'company' => FavoriteCompanyService::class,
    ];
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(FavoriteRequest $request)
    {
        $service = new FavoriteService(new ($this->services[$request->get('type')]));
        return $service->toJson();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function toggle(FavoriteToggleRequest $request)
    {
        $service = new FavoriteService(new ($this->services[$request->get('type')]));
        $service->toggle($request->get('id'));
    }
}