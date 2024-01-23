<?php

namespace Modules\Mortgage\Http\Controllers\Front;

use App\DataTransferObjects\MortgageExportDto;
use App\Events\AdminNotification;
use App\Exports\MortgagesExport;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Mortgage\Entities\Mortgage;
use Modules\Mortgage\Http\Requests\MortgageRequest;

class MortgageController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function showForm()
    {
        return view('mortgage::front-end.index');
    }

    public function store(MortgageRequest $request)
    {
        $mortgage = Mortgage::create($request->all());
        event(new AdminNotification(__('messages.new_mortgage_request_is_added', ['name' => $request->name])));
        return \redirect()->back()->with('message', __('messages.mortgage_is_received'));
    }
}