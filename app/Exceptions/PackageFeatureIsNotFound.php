<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PackageFeatureIsNotFound extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        if (request()->is('api/*')) {

            return response([
                "message" => __('messages.package_feature_not_found'),
                'is_expired' => true,
            ], Response::HTTP_BAD_REQUEST);
        }
        return redirect()->route('front.profile.subscription.show');
    }
}