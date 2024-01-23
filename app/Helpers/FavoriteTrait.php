<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

trait FavoriteTrait
{

    public function addIsFavorite(int $modelID, string $modelType): bool
    {
        if (auth()->guard('sanctum')->check()) {

            return DB::table('favorites')
                ->where('user_id', auth('sanctum')->id())
                ->where('favoritable_id', $modelID)
                ->where('favoritable_type', $modelType)
                ->exists();
        }
        return false;
    }
}