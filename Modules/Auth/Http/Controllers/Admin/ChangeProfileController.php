<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\DataTransferObjects\ChangeProfileDTO;
use Modules\Auth\Http\Requests\Admin\UpdateProfileRequest;
use Modules\Auth\Services\AuthService;

class ChangeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function showForm()
    {
        return view('auth::admin.change-profile');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UpdateProfileRequest $request)
    {
        $changeProfileDto = new ChangeProfileDTO(
            $request->get('name'),
            $request->get('email'),
            $request->get('phone'),
        );
        AuthService::changeProfile($changeProfileDto);
        return redirect_response('success', __('messages.success_update'), "dashboard");
    }
}