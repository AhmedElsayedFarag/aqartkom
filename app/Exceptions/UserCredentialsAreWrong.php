<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;

class UserCredentialsAreWrong extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        if (\request()->isJson())
            return response()->json([
                'message' => __('auth.failed'),
            ], 422);
        throw ValidationException::withMessages([
            'phone' => trans('auth.failed'),
        ]);
    }
}