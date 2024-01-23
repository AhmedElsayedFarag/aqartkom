<?php

namespace Modules\Estate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Estate\Entities\Estate;
use Modules\Estate\Entities\EstateMedia;
use Modules\Estate\Http\Requests\EstateMediaRequest;
use Modules\Estate\Services\EstateService;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Services\MediaService;

class EstateGalleryController extends Controller
{
    public function __construct(private MediaService $mediaService, private EstateService $estateService)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Estate $estate)
    {
        $media = $estate->media()->paginate();
        return view('estate::admin.index', compact('media', 'estate'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Estate $estate)
    {
        return view('estate::admin.create', compact('estate'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(EstateMediaRequest $request, Estate $estate)
    {
        $media = [];
        foreach ($request->file('media') as $file) {
            $mediaDto = new MediaDto($file, 'media');
            $media[] = $this->mediaService->create($mediaDto)->uuid;
        }
        $this->estateService->moveMedia($estate, $media);
        return \success_add('media.index', ['estate' => $estate->id]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Estate $estate,  $media)
    {
        $media = EstateMedia::firstWhere('id', $media);
        abort_if(is_null($media), 404);
        $this->estateService->deleteMedia([$media->uuid]);
        return \success_delete('media.index', ['estate' => $estate->id]);
    }
}