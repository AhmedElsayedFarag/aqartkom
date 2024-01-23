<?php

namespace Modules\Auction\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BidIsPendingException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        if (\request()->isJson())
            return response(["message" => __('messages.request_is_not_approved_yet')], Response::HTTP_BAD_REQUEST);
        else
            throw ValidationException::withMessages([
                'amount' => __('messages.request_is_not_approved_yet')
            ]);
    }
}