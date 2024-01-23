<?php

namespace Modules\Auth\DataTransferObjects;

class ChangePasswordDTO
{

    public function __construct(
        public string $oldPassword,
        public string $newPassword,
        public string $currentPassword
    ) {
    }
}