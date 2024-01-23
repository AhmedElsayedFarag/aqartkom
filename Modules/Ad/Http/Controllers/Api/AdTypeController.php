<?php

namespace Modules\Ad\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Ad\Services\AdTypesService;

class AdTypeController extends Controller
{
    public function __invoke()
    {
        return AdTypesService::getAll();
    }
}