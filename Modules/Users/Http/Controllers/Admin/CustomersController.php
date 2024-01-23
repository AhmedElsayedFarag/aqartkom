<?php

namespace Modules\Users\Http\Controllers\Admin;

use App\DataTransferObjects\FCMDTO;
use App\Exports\CustomersExport;
use App\Helpers\FCMHelper;
use App\Jobs\AddNotificationsToUsersJob;
use App\Notifications\SendMessageUserNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Services\AdService;
use Modules\Auth\DataTransferObjects\ChangeProfileImageDTO;
use Modules\Auth\Entities\User;
use Modules\Auth\Entities\VerificationCode;
use Modules\Auth\Services\AuthService;
use Modules\Users\Http\Requests\SendTopicRequest;
use Modules\Users\Http\Requests\UpdateCustomerRequest;
use Modules\Users\Services\UsersService;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $usersService = new UsersService();
        $customers = $usersService->getCustomers();

        return view('users::customers.index', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(User $user)
    {
        $adService = new AdService();

        $ads = $adService->getUserAds($user->id, '');

        return view('users::customers.show', compact('user', 'ads'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view('users::customers.edit', compact('user'));
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
        return success_update('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \success_delete('customer.index');
    }
    public function sendTopic(SendTopicRequest $request)
    {
        $title = $request->get('title');
        $body = $request->get('description');
        $dto = new FCMDTO(
            title: $title,
            body: $body,
            topic: "customer",
        );
        $dto = $dto->setType('topic');
        FCMHelper::sendTopic($dto, 'customer');

        return redirect()->back();
    }
    public function sendMessage(Request $request)
    {

        $user = User::firstWhere('uuid', $request->get('user_id'));
        $user->notify(new SendMessageUserNotification($user->mobile_token, $request->get('title'), $request->get('description')));
        return redirect()->back();
    }
    public function exportExcel()
    {
        return \Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function otps()
    {
        // 'phone', $phone
        $otps = VerificationCode::when(request()->get('search'), function ($query) {
            $query->where('phone', 'like', '%' . request()->get('search') . '%');
        })->latest()->paginate();
        return view('users::otps', compact('otps'));
    }
}