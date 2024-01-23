<?php

namespace Modules\Favorite\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Modules\Favorite\Http\Requests\FavoriteRequest;
use Modules\Favorite\Services\FavoriteAdService;
use Modules\Favorite\Services\FavoriteAuctionService;
use Modules\Favorite\Services\FavoriteCompanyService;
use Modules\Favorite\Services\FavoriteService;

class FavoritesController extends Controller
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
    public function __invoke(FavoriteRequest $request)
    {
        $service = new FavoriteService(new ($this->services[$request->get('type')]));
        return $service->render();
    }
}
