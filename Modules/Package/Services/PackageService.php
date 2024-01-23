<?php

namespace Modules\Package\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Package\Entities\Package;

class PackageService
{
    public function __construct()
    {
    }
    public function getAll()
    {
        return Cache::rememberForever('packages', function () {
            return Package::all();
        });
    }
}
