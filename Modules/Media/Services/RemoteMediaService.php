<?php

namespace Modules\Media\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Contracts\MediaManagementInterface;
use Illuminate\Support\Str;

class RemoteMediaService implements MediaManagementInterface
{

    public function store(UploadedFile $file, string $directoryName)
    {
        $fileName = $this->hashName($file->getClientOriginalExtension(), $directoryName);
        Storage::disk("s3")->put($fileName, $file->getContent());
        return $fileName;
    }
    public function delete(string $mediaUrl)
    {
        $disk = Storage::disk('s3');
        if ($disk->exists($mediaUrl)) {
            $disk->delete($mediaUrl);
        }
    }
    /**
     * Get a filename for the file.
     *
     * @param  string|null  $path
     * @return string
     */
    public function hashName(string $extension, string $directory)
    {
        $hash =  Str::random(40);
        return $directory . "/" . $hash . '.' . $extension;
    }
}