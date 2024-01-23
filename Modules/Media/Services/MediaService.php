<?php

namespace Modules\Media\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Media\Contracts\MediaManagementInterface;
use Modules\Media\DataTransferObject\MediaDto;
use Modules\Media\Entities\Media;

class MediaService
{
    public function __construct(private MediaManagementInterface $mediaManagementService)
    {
    }
    public function create(MediaDto $mediaDto)
    {
        $link = $this->mediaManagementService->store($mediaDto->file, $mediaDto->directory);
        $extension = $mediaDto->file->getClientOriginalExtension();
        // if ($this->getType($extension) == 'image') {
        //     $img = \Image::make(public_path($link));
        //     $watermark = \Image::make(public_path('watermark.png'));
        //     // $watermark->resize(230, 100);
        //     $img->insert($watermark, 'center', 10, 10);
        //     $img->save(public_path($link));
        // }
        return Media::create([
            'url' => $link,
            'type' => $this->getType($extension),
            'storage_location' => config('filesystems.location_storage'),
            'new_url' => Storage::disk('s3')->putFile('estates', new \Illuminate\Http\File(public_path($link))),
            // 'is_converted' => true,
        ]);
    }
    private function getType(string $extension)
    {
        return $extension == 'mp4' ? "video" : "image";
    }
    public function delete(Media $media)
    {
        $this->mediaManagementService->delete($media->url);
        $media->delete();
    }
}
