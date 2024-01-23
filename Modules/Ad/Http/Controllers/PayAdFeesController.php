<?php

namespace Modules\Ad\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\Ad;

class PayAdFeesController extends Controller
{

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Ad $ad)
    {
        return view('ad::front.pay-ad-fees', compact('ad'));
    }
    public function store()
    {
    }
}