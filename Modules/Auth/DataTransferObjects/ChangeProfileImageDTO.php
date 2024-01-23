<?php

namespace Modules\Auth\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class ChangeProfileImageDTO
{

    public function __construct(
        public UploadedFile $image,
        public string $oldImage,
    ) {
    }
}