<?php

namespace Modules\Setting\DataTransferObjects;


class SettingsCollectionDTO
{

    private array $collection = [];
    private function __construct()
    {
    }
    public static function __callStatic($name, $arguments)
    {
        return (new self)->$name($arguments);
    }
    protected  function fromArray(array $data)
    {
        foreach ($data[0] as $key => $value) {
            $this->collection[] = new SettingsDTO(key: $key, value: $value);
        }
        return $this;
    }
    public function format(string $group): array
    {
        $formattedSettings = [];

        foreach ($this->collection as $setting) {
            $formattedSettings[] = [
                'key' => $setting->key,
                'group' => $group,
                'value' => $setting->value,
            ];
        }
        return $formattedSettings;
    }
}