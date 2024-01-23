<?php

namespace Modules\Ad\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Ad\Entities\AdType;

class AdTypesService
{

    public static function __callStatic($name, $arguments)
    {
        return (new Self)->$name(...$arguments);
    }

    protected function getAll()
    {
        return Cache::rememberForever('ad_types', function () {
            return AdType::select(['id', 'name', 'type'])->get()->groupBy('type')->toArray();
        });
    }
}