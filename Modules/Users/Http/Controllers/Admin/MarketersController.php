<?php

namespace Modules\Users\Http\Controllers\Admin;

use App\DataTransferObjects\FCMDTO;
use App\Helpers\FCMHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Services\AdService;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Entities\User;
use Modules\Auth\Services\AuthService;
use Modules\Transaction\Entities\Transaction;
use Modules\Users\Http\Requests\SendTopicRequest;
use Modules\Users\Http\Requests\UpdateMarketerRequest;
use Modules\Users\Services\UsersService;

class MarketersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $usersService = new UsersService();
        $marketers = $usersService->getMarketers();
        return view('users::marketers.index', compact('marketers'));
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
                $ads = $adService->getUserLicensedAds($user->id, '');
            } elseif ($ad_status == 'not-licensed') {
                $ads = $adService->getUserUnlicensedAds($user->id);
            } elseif ($ad_status == 'market') {
                $ads = $adService->getUserAdMarketing($user->id, 'pending');
            } elseif ($ad_status == 'request') {
                $ads = $adService->getUserAds($user->id, 'approved', true);
            } elseif ($ad_status == 'featured') {
                $ads = $adService->getFeaturedUserAds($user->id);
            }


            $compact['ads'] = $ads;
        }

        if (request()->has('status')) {
            $status = request()->get('status');

            if ($status == 'packages') {
                $subscription = $user->activeSubscription();
                $compact['subscription'] = $subscription;
            } else {
                $transactions = Transaction::where('user_id', $user->id)->paginate(10);
                $compact['transactions'] = $transactions;
            }
        }

        return view('users::marketers.show', $compact);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('users::marketers.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateMarketerRequest $request, User $user)
    {
        if ($request->has('profile_image')) {

            $dto = new ChangeProfileImageDTO(
                image: $request->file('profile_image'),
                oldImage: $user->profile
            );
            AuthService::changeProfileImage($dto, $user);
        }
        $user->update($request->validated());
        $user->marketerProfile()->update($request->only(['whatsapp_number', 'advertisement_number']));
        return success_update('marketer.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \success_delete('marketer.index');
    }

    /**
     * switch user to is featured only for companies and marketers
     *
     * @param User $user
     * @return void
     */
    public function setIsFeatured(User $user)
    {
        abort_if(!auth()->user()->hasRole('admin'), 404);

        if ($user->is_featured == 0) {
            $user->update([
                'is_featured' => 1
            ]);
        } else {
            $user->update([
                'is_featured' => 0
            ]);
        }


        return success_update('marketer.index');
    }
    public function sendTopic(SendTopicRequest $request)
    {
        $dto = new FCMDTO(
            title: $request->get('title'),
            body: $request->get('description'),
            topic: "marketer",
        );
        FCMHelper::sendTopic($dto, 'marketer');
        return redirect()->back();
    }
}