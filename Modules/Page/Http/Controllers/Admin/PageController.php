<?php

namespace Modules\Page\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\PageUpdateRequest;

class PageController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Page $page)
    {
        return view('page::edit', \compact('page'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PageUpdateRequest $request, Page $page)
    {
        $page->update(['content' => $request->get('content')]);
        return \success_update('page.edit', ['page' => $page->slug]);
    }
}