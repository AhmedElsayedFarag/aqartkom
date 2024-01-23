<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PackageFeatureIsExpired extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return response([
            "message" => __('messages.package_feature_is_expired'),
            'is_expired' => true,
        ], Response::HTTP_BAD_REQUEST);
    }
}