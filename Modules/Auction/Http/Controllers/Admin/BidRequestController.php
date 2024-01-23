<?php

namespace Modules\Auction\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auction\Entities\Bid;
use Modules\Auction\Entities\BidRequest;
use Modules\Auction\Services\BidService;

class BidRequestController extends Controller
{
    public function __construct(private BidService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $requests = $this->service->getAll();
        return view('auction::admin.bid-requests.index', \compact('requests'));
    }
    public function accept(Bid $bid)
    {
        $this->service->accept($bid);
        return \success_update('bid-request.index');
    }
    public function cancel(Bid $bid)
    {
        $this->service->cancel($bid);
        return \success_update('bid-request.index');
    }
}