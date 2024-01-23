<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AdMediaMustBeAddedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return response(["message" => __('messages.ad_must_have_media')], Response::HTTP_BAD_REQUEST);
    }
}