<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Transformers\PageShowResource;

class PageController extends Controller
{



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Page $page)
    {
        return new PageShowResource($page);
    }
}