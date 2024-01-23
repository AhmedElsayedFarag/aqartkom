<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Entities\User;

class LoginNafathController extends Controller
{
    public function __invoke(Request $request)
    {
        if (is_null($request->user) || is_null($request->random)) {
            return \redirect()->route('front.login');
        }
        $userID = $request->user;
        $token = $request->random;
        $user = User::query()->where('nationality_id', $userID)->where('one_time_login', $token)->first();
        if (is_null($user)) {
            return \redirect()->route('front.login');
        }
        $user->update([
            'one_time_login' => null,
        ]);
        Auth::login($user, true);
        return \redirect()->route('front.index');
    }
}
