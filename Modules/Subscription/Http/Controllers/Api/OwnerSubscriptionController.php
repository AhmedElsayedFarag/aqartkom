<?php

namespace Modules\Subscription\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscription\Http\Requests\SubscriptionRequest;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Transformers\SubscriptionShowResource;

class OwnerSubscriptionController extends Controller
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
        $subscription =
            SubscriptionService::getActiveSubscription();
        if ($subscription)
            return new SubscriptionShowResource($subscription);
        return response()->json([
            'is_subscribed' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SubscriptionRequest $request)
    {
        return $this->service->createOwner($request);
    }
    public function cancel()
    {
        $this->service->cancel();
        return JsonResponseMessages::deleted();
    }
}
