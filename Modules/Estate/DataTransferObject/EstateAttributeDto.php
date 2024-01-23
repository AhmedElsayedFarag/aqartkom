<?php

namespace Modules\Estate\DataTransferObject;

class EstateAttributeDto
{

    public function __construct(public int $attribute, public $value)
    {
    }
}