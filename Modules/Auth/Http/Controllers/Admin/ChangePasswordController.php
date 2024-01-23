<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\DataTransferObjects\ChangePasswordDTO;
use Modules\Auth\Http\Requests\Admin\UpdatePasswordRequest;
use Modules\Auth\Services\AuthService;

class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function showForm()
    {
        return view('auth::admin.change-password');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UpdatePasswordRequest $request)
    {
        $changePasswordDto = new ChangePasswordDTO(
            $request->get('password'),
            $request->get('new_password'),
            auth()->user()->password,
        );
        AuthService::changePassword($changePasswordDto);
        return redirect_response('success', __('messages.success_update'), "dashboard");
    }
}