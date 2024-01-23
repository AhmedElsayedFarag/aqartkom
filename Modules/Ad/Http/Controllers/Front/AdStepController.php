<?php

namespace Modules\Ad\Http\Controllers\Front;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdStepController extends Controller
{
    public function showForm()
    {
        return view('ad::front.ad-step');
    }
    public function redirect(Request $request)
    {
        //check on package features to see if the user can create ads or redirect him to packages
        $step = $request->step;
        if ($step == 1) {
            \session(['ad_type' => 'licensed-ad']);
            return \redirect()->to(route('front.ad.create'));
        }
        if ($step == 2) {
            \session(['ad_type' => 'marketing-ad']);
            return \redirect()->to(route('front.ad-marketing.create'));
        }
        if ($step == 3) {
            \session(['ad_type' => 'license-request']);
            return \redirect()->to(route('front.license-request.create'));
        }
        return redirect()->back();
    }
}