<?php

namespace Modules\Users\Http\Controllers\Admin;

use App\DataTransferObjects\FCMDTO;
use App\Exports\CustomersExport;
use App\Exports\OwnersExport;
use App\Helpers\FCMHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Services\AdService;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\AuthService;
use Modules\Package\Services\Admin\OwnerPackageService;
use Modules\Package\Services\Api\PackageService;
use Modules\Transaction\Entities\Transaction;
use Modules\Users\Http\Requests\SendTopicRequest;
use Modules\Users\Http\Requests\UpdateCustomerRequest;
use Modules\Users\Services\UsersService;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $usersService = new UsersService();
        $customers = $usersService->getOwners();
        return view('users::owners.index', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(User $user)
    {
        $compact = [
            'user' => $user
        ];

        if (request()->has('ad-status')) {
            $adService = new AdService();

            $ad_status = request()->get('ad-status');

            if ($ad_status == 'licensed') {
                $ads = $adService->getUserLicensedAds($user->id, ''); //licensed or is licensed request and completed
            } elseif ($ad_status == 'not-licensed') {
                $ads = $adService->getUserUnlicensedAds($user->id); //not a license request or is licensed
            } elseif ($ad_status == 'request') {
                $ads = $adService->getUserAds($user->id, 'approved', true);
            } elseif ($ad_status == 'featured') {
                $ads = $adService->getFeaturedUserAds($user->id);
            }

            $compact['ads'] = $ads;
        }

        $status = request()->get('status');
        if ($status == 'packages') {
            $subscription = $user->activeSubscription();
            $compact['subscription'] = $subscription;
        }
        if ($status == 'payments') {
            $transactions = Transaction::where('user_id', $user->id)->paginate(10);
            $compact['transactions'] = $transactions;
        }
        return view('users::owners.show', $compact);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('users::owners.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCustomerRequest $request, User $user)
    {
        if ($request->has('profile_image')) {

            $dto = new ChangeProfileImageDTO(
                image: $request->file('profile_image'),
                oldImage: $user->profile
            );
            AuthService::changeProfileImage($dto, $user);
        }
        $user->update($request->validated());
        return success_update('owner.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \success_delete('owner.index');
    }
    public function sendTopic(SendTopicRequest $request)
    {
        $dto = new FCMDTO(
            title: $request->get('title'),
            body: $request->get('description'),
            topic: "owner",
        );
        FCMHelper::sendTopic($dto, 'owner');
        return redirect()->back();
    }
    public function exportExcel()
    {
        return \Excel::download(new OwnersExport, 'owners.xlsx');
    }
}