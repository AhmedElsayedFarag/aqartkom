<?php

namespace Modules\Ad\Http\Controllers\Front\User;

use App\Services\TakamolatService;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\Ad;
use Modules\Ad\Http\Requests\AdMarketingLicenseRequest;

class AddAdLicenseController extends Controller
{
    public function showForm(Ad $ad)
    {
        if ($ad->is_licensed) {
            return redirect()->back();
        }
        if ($ad->user_id != auth()->id()) {
            return redirect()->back();
        }
        return view('ad::front.add-license-number', compact('ad'));
    }
    public function store(AdMarketingLicenseRequest $request, Ad $ad)
    {
        $result = TakamolatService::createRequest(
            $request->license_number,
            $request->nationality_number,
            $request->nationality_type == 'marketer' ? 1 : 2
        );
        if ($result['success']) {
            $ad->update([
                'license_number' => $request->get('license_number'),
                'is_licensed' => true,
                'is_request' => false,
            ]);
            return redirect()->to(route('front.ad.show', $ad->id));
        }
        return redirect()->back()->with('fail', $result['message']);
    }
}
