<?php

namespace Modules\Setting\DataTransferObjects;

class SettingsDTO
{

    public function __construct(public string $key, public string $value)
    {
    }
}