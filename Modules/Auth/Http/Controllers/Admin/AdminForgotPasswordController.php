<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminForgotPasswordController extends Controller
{
    public function __invoke()
    {
        return view('auth::admin.forgot-password');
    }
}
