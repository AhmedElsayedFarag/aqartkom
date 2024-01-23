<?php

namespace Modules\Media\DataTransferObject;

use Illuminate\Http\UploadedFile;

class MediaDto
{
    public function __construct(
        public UploadedFile $file,
        public string $directory,
    ) {
    }
}