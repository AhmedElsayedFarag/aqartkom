<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NoChosenStepException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */

    public function render()
    {
        return redirect()->route('front.profile.subscription.show');
    }
}