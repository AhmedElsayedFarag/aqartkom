<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NoLicenseNumberProvidedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        if (request()->is('api/*'))
            return response(["message" => __('messages.no_license_number_provided')], Response::HTTP_BAD_REQUEST);
        return redirect()->route('front.user.check-license.show-form');
    }
}