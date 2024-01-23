<?php

namespace Modules\Users\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\Api\MarketersFilterRequest;
use Modules\Auth\Services\MarketerProfileService;

class MarketersController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(MarketersFilterRequest $request)
    {
        $marketerService = new MarketerProfileService();
        $marketers = $marketerService->getAll($request);

        return view('users::front.marketers', \compact('marketers'));
    }
}