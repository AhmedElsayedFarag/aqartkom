<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AdRefreshIsImmutableException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return response(["message" => __('messages.ad_refresh_cannot_be_done')], Response::HTTP_BAD_REQUEST);
    }
}
