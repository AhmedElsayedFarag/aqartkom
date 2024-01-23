<?php

namespace Modules\CustomerMessage\Http\Controllers;

use App\Helpers\JsonResponseMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Modules\CustomerMessage\Entities\CustomerMessage;
use Modules\CustomerMessage\Http\Requests\CustomerMessageRequest;
use Modules\CustomerMessage\Http\Resources\CustomerMessageResource;

class CustomerMessagesController extends Controller
{
    public function __invoke(CustomerMessageRequest $request)
    {
        CustomerMessage::create($request->all());
        return JsonResponseMessages::created();
    }
}
