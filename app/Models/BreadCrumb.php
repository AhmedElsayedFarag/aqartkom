<?php

namespace App\Models;

class BreadCrumb
{
    public function __construct(public string $name, public ?string $route = null)
    {
    }
}