<?php

namespace App\Helpers;

class JsonResponseMessages
{
    public static function deleted(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json(['message' => __('messages.success_delete')]);
    }
    public static function created(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json(['message' => __('messages.added_successfully')], 201);
    }
    public static function updated(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json(['message' => __('messages.success_update')]);
    }
    public static function featuredSuccessfully(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json([
                'message' => __('messages.ad_is_featured'),
                'is_featured' => true,
            ]);
    }
    public static function error(): \Illuminate\Http\JsonResponse
    {
        return response()
            ->json(['message' => __('messages.something_happened')], 500);
    }
}