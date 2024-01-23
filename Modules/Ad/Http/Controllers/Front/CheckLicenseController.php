<?php

namespace Modules\Ad\Http\Controllers\Front;

use App\Services\TakamolatService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Http\Requests\AdMarketingLicenseRequest;

class CheckLicenseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function showForm()
    {
        return view('ad::front.license-check');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdMarketingLicenseRequest $request)
    {
        try {
            $result = TakamolatService::createRequest(
                $request->license_number,
                $request->nationality_number,
                $request->nationality_type == 'marketer' ? 1 : 2
            );
            if ($result['success']) {
                session([
                    'license_number' => $request->license_number
                ]);
                return \redirect()->to(route('front.ad.create'));
            } else {
                return redirect()->back()->with('fail', __('messages.license_is_not_found'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', __('messages.something_happened'));
        }
    }
}