<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestionsRequest;
use Illuminate\Http\Request;
use Modules\Ad\Services\AdService;
use Modules\Category\Entities\Category;
use Modules\Category\Services\CategoriesService;
use Modules\CustomerMessage\Entities\CustomerMessage;
use Modules\Page\Entities\Page;

class FrontEndController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
        $categories = CategoriesService::getAll();
        $latestAds = (new AdService())->getFeatured()->limit(6)->get();
        return view('front-end.index', \compact('categories', 'latestAds'));
    }
    public function policy(Page $page)
    {

        return view('front-end.policy', \compact('page'));
    }
    public function showSuggestionsForm()
    {
        return view('suggestions');
    }
    public function storeSuggestions(SuggestionsRequest $request)
    {
        CustomerMessage::create($request->validated());
        return redirect()->back()->with('message', __('messages.suggesions_created'));
    }
}