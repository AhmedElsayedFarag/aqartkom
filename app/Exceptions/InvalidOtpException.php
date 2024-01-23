<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class InvalidOtpException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return  request()->isJson() ?
            response(["message" => __('auth.verification_code_is_not_found')], Response::HTTP_BAD_REQUEST)
            : throw  ValidationException::withMessages([
                'code' => [__('auth.verification_code_is_not_found')],
            ]);
    }
}