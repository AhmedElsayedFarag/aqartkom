<?php

namespace Modules\Mortgage\Http\Controllers\Api;

use App\Events\AdminNotification;
use App\Helpers\JsonResponseMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Mortgage\Entities\Mortgage;
use Modules\Mortgage\Http\Requests\MortgageRequest;

class MortgageController extends Controller
{

    public function __invoke(MortgageRequest $request)
    {
        $mortgage = Mortgage::create($request->all());
        event(new AdminNotification(__('messages.new_mortgage_request_is_added', ['name' => $request->name])));



        return JsonResponseMessages::created();
    }
}