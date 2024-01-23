<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Auth\Http\Requests\AdminLoginRequest;

class AdminAuthenticationController extends Controller
{
    public function showForm()
    {
        return view("auth::admin.login");
    }
    public function store(AdminLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}