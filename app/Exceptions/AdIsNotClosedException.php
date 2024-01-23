<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AdIsNotClosedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return response(["message" => __('messages.ad_is_not_closed')], Response::HTTP_BAD_REQUEST);
    }
}