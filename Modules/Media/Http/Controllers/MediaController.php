<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Entities\Media;
use Modules\Media\Http\Requests\StoreMediaRequest;
use Modules\Media\Http\Resources\MediaResource;
use Modules\Media\Services\MediaService;

class MediaController extends Controller
{

    public function __construct(private MediaService $mediaService)
    {
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreMediaRequest $request)
    {
        $mediaDto = new MediaDto($request->file('media'), 'media');
        $media = $this->mediaService->create($mediaDto);
        return new MediaResource($media);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Media $media)
    {
        $this->mediaService->delete($media);
    }
}