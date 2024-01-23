<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NoActiveSubscriptionException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        if (request()->is('api/*'))
            return response(["message" => __('messages.subscription_is_not_active')], Response::HTTP_BAD_REQUEST);
        return redirect()->route('front.profile.packages');
    }
}