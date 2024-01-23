<?php

namespace Modules\CustomerMessage\Http\Controllers\Admin;

use App\Helpers\JsonResponseMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Modules\CustomerMessage\Entities\CustomerMessage;
use Modules\CustomerMessage\Http\Requests\CustomerMessageRequest;
use Modules\CustomerMessage\Http\Resources\CustomerMessageResource;

class CustomerMessagesController extends Controller
{

    public function index()
    {
        $search = request()->search;
        $messages = CustomerMessage::latest()
            ->when($search, function ($q) use ($search) {
                return $q->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            })
            ->paginate(10);
        return view('customer_message::admin.index', \compact('messages'));
    }
    public function destroy(CustomerMessage $customer_message)
    {
        $customer_message->delete();
        return \success_delete('customer-message.index');
    }
}
