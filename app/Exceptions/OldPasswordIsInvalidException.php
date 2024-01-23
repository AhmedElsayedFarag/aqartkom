<?php

namespace App\Exceptions;

use Exception;

class OldPasswordIsInvalidException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $request->expectsJson() ? response()->json([
            'message' => trans('messages.old_password_cannot_be_changed'),
        ], 422) : redirect()->back()
            ->withInput($request->input())
            ->withErrors([
                'old_password' => trans('messages.old_password_cannot_be_changed')
            ]);
    }
}