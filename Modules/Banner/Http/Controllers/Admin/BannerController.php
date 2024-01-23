<?php

namespace Modules\Banner\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\StoreBannerRequest;
use Modules\Banner\DataTransferObject\BannerDto;

use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Services\BannerService;

class BannerController extends Controller
{


    public function index()
    {
        $banners = Banner::with('ad:estate_id,id', 'ad.estate:id,title')->latest()->paginate(15);
        return view('banner::index', compact('banners'));
    }
    public function create()
    {
        return view('banner::create');
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreBannerRequest $request)
    {
        Banner::create([
            'url' => $request->file('image')->store('', ['disk' => 'banners']),
            'ad_id' => $request->ad_id
        ]);
        return \success_add('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return \success_delete('banner.index');
    }
}
