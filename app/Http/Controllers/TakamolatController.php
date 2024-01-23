<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstateCheckRequest;
use App\Services\TakamolatService;
use Illuminate\Http\Request;

class TakamolatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(EstateCheckRequest $request)
    {

        $response = TakamolatService::createRequest(
            $request->license_number,
            $request->nationality_number,
            $request->nationality_type == 'marketer' ? 1 : 2
        );
        if (!is_null($response)) {
            return response()->json($response);
        }
        return response()->json([
            'success' => false,

            'message' => __('messages.license_is_not_found'),
        ], 400);
    }
}
