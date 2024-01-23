<?php

namespace Modules\SEO\Services;

use Illuminate\Support\Facades\Cache;
use Modules\SEO\Entities\SEO;

class SeoService
{
    public static function getAll()
    {
        return Cache::rememberForever('seo', function () {
            return SEO::select(['key', 'value'])->get()->keyBy('key')->toArray();
        });
    }
}