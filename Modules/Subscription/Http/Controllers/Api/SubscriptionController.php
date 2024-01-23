<?php

namespace Modules\Subscription\Http\Controllers\Api;

use App\Helpers\JsonResponseMessages;
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
    public function store(StoreSubscriptionRequest $request)
    {
        $this->service->create($request);
        return JsonResponseMessages::created();
    }
}
