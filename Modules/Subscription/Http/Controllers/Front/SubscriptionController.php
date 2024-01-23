<?php

namespace Modules\Subscription\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\City\Entities\City;
use Modules\Package\Entities\Package;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Http\Requests\StoreSubscriptionRequest;
use Illuminate\Support\Str;
use Modules\Package\Services\PackageService;
use Modules\Subscription\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function __construct(private SubscriptionService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('subscription::front-end.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = (new PackageService)->getAll();
        $cities = City::select(['id', 'name'])->get();
        return view('subscription::front-end.create', \compact('packages', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $this->service->create($request);
        return redirect()->route('front.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('subscription::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('subscription::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        //
    }
}
