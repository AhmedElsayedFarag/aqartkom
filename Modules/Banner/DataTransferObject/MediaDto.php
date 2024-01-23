<?php

namespace Modules\Banner\DataTransferObject;

use Illuminate\Http\UploadedFile;

class BannerDto
{
    public function __construct(
        public UploadedFile $file,
        public string $directory,
    ) {
    }
}
