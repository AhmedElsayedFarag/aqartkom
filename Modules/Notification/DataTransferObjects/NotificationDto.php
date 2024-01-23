<?php

namespace Modules\Notification\DataTransferObjects;

use Illuminate\Support\Str;
use Modules\Auth\Entities\User;

class NotificationDto
{

    public function __construct(
        public string $title,
        public string $body,
        public string $type,
    ) {
    }
}
