<?php

namespace Modules\Banner\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Banner\DataTransferObject\BannerDto;
use Modules\Banner\Entities\Banner;

use Modules\Banner\Http\Requests\StoreBannerRequest;
use Modules\Banner\Http\Resources\BannerResource;

use Modules\Banner\Services\BannerService;

class BannerController extends Controller
{
    public function __invoke()
    {
        return BannerResource::collection(Banner::with(['ad:id,uuid'])->get());
    }
}
