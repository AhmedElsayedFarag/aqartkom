<?php

namespace Modules\Package\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Package\Entities\Package;
use Modules\Package\Services\Api\PackageService;
use Modules\Package\Transformers\PackageResource;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Transformers\SubscriptionShowResource;

class PackageController extends Controller
{
    public function __construct(public SubscriptionService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $packages = PackageService::getAll(auth()->user()->type);
        $packages = PackageResource::collection(PackageService::getAll(auth()->user()->type))->response()->getData(true);

        // return $packages;
        return view('package::index', [
            'packages' => $packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('package::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        $subscription = SubscriptionService::getActiveSubscription(auth()->id());

        return view('package::show', ['subscription' => $subscription]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('package::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function cancel()
    {
        $this->service->cancel();

        return redirect()->back();
    }
}