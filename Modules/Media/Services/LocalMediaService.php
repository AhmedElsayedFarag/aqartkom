<?php

namespace Modules\Media\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Contracts\MediaManagementInterface;
use Modules\Media\Entities\Media;

class LocalMediaService implements MediaManagementInterface
{
    public function store(UploadedFile $file, string $directoryName)
    {
        $link = Storage::disk($directoryName)->url($file->store('', ['disk' => $directoryName]));
        $storageLink = str_replace(config('app.url') . '/', '', $link);

        return $storageLink;
    }
    public function delete(string $mediaUrl)
    {
        delete_file($mediaUrl);
    }
}
