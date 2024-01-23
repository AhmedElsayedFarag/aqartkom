<?php

namespace Modules\Estate\DataTransferObject;

class EstatableDto
{

    public function __construct(public string $type, public string $id)
    {
    }
    public function toArray(): array
    {
        return [
            'estatable_id' => $this->id,
            'estatable_type' => $this->type,
        ];
    }
}