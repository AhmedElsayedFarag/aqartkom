<?php

namespace Modules\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface MediaManagementInterface
{
    public function store(UploadedFile $file, string $directoryName);
    public function delete(string $mediaUrl);
}