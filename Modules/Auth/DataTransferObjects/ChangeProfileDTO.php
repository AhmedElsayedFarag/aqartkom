<?php

namespace  Modules\Auth\DataTransferObjects;


class ChangeProfileDTO
{

    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone = null
    ) {
    }

    public function toArray()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];
        if ($this->phone)
            $data['phone'] = $this->phone;
        return $data;
    }
}