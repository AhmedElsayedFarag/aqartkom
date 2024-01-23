<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\GetAdStatistics;
use App\Actions\GetAdTypeStatistics;
use App\Actions\GetAdUserTypeStatistics;
use App\Actions\GetUserTypeStatistics;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Entities\AdReport;
use Modules\Ad\Entities\AdVisit;
use Modules\Ad\Enums\AdStatusEnum;
use Modules\Auction\Entities\Auction;
use Modules\Auction\Entities\Bid;
use Modules\Auth\Entities\CompanyProfile;
use Modules\Auth\Entities\MarketerProfile;
use Modules\Auth\Entities\User;
use Modules\Category\Entities\Category;
use Modules\Subscription\Entities\Subscription;

class DashboardController extends Controller
{
    public function __invoke()
    {

        $NumberOfSubscribtions = Subscription::query()
            ->validFilter()
            ->count();
        $profits = DB::table('transactions')->where('status', 'approved')->sum('subtotal_after_discount');
        $sellAds = Ad::join('estates', 'estates.id', '=', 'ads.estate_id')
            ->status('approved')
            ->where('ads.type', 'sell')
            ->groupBy('category_id')
            ->select([DB::raw('Count(ads.id) as ads_count'), 'category_id'])
            ->get()
            ->keyBy('category_id')
            ->toArray();

        $rentAds = Ad::join('estates', 'estates.id', '=', 'ads.estate_id')
            ->status('approved')
            ->where('ads.type', 'rent')
            ->groupBy('category_id')
            ->select([DB::raw('Count(ads.id) as ads_count'), 'category_id'])
            ->get()
            ->keyBy('category_id')
            ->toArray();
        $categories = Category::select(['id', 'name'])->get();

        $latestAds = Ad::select(['estate_id', 'user_id', 'owner_name'])
            ->with([
                'estate' => fn ($query) => $query->select(['id', 'title']),
                'owner' => fn ($query) => $query->select(['id', 'name', 'profile'])
            ])
            ->status('approved')
            ->latest()
            ->limit(6)
            ->get();

        $adTypeDto = (new GetAdTypeStatistics())->handle();
        $userTypeDto = (new GetUserTypeStatistics())->handle();
        $adDto = (new GetAdStatistics())->handle();
        return view('auth::admin.dashboard', compact(
            'adTypeDto',
            'userTypeDto',
            'adDto',
            'latestAds',
            'sellAds',
            'rentAds',
            'categories',
            'NumberOfSubscribtions',
            'profits'
        ));
    }
}