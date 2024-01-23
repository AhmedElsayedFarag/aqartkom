<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Modules\Auth\Services\AuthService;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function showForm()
    {
        return view('auth::front-end.register');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function store(RegisterRequest $request)
    {
        Auth::login(AuthService::register($request), true);
        return redirect()->route('front.index');
    }
}
