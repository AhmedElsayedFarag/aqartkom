<?php

namespace App\DataTransferObjects;

class FCMDTO
{
    private array $data = [
        'is_hidden' => '0',
        'notify_type' => 'general'
    ];
    public function __construct(
        private string $title,
        private string $body,
        private ?string $userToken = null,
        private ?string $topic = null,
    ) {
    }
    public function getNotification(): array
    {
        return [
            "body" => $this->body,
            "title" => $this->title
        ];
    }
    public function getTopic()
    {
        return $this->topic;
    }
    public function getToken()
    {
        return $this->userToken;
    }
    public function isHidden()
    {
        $this->data['is_hidden'] = '1';
        return $this;
    }
    public function addData(string $key, string $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
    public function setType(string $type)
    {
        $this->data['notify_type'] = $type;
        return $this;
    }
    public function getData()
    {
        return $this->data;
    }
}