<?php

namespace Modules\Setting\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Setting\DataTransferObjects\SettingsCollectionDTO;
use Modules\Setting\Entities\Settings;

class SettingsService
{
    public static function __callStatic($name, $arguments)
    {
        return (new self())->$name(...$arguments);
    }
    public function update(string $group, SettingsCollectionDTO $settingsCollectionDTO)
    {
        Settings::upsert($settingsCollectionDTO->format($group), ['key']);
        Cache::forget('settings');
    }
    protected function cache()
    {
        return Cache::rememberForever('settings', function () {
            $formattedData = [];
            $settings = Settings::select(['key', 'group', 'value'])->get()->toArray();
            foreach ($settings as $setting) {
                $group = $setting['group'];
                $key = $setting['key'];
                $formattedData[$group][$key] = $setting;
            }
            return $formattedData;
        });
    }
    public function get(string $group): array
    {
        return $this->cache()[$group];
    }
    protected function getSingle(string $group, string $key)
    {
        return $this->get($group)[$key];
    }
    protected function getAppSettings()
    {
        return $this->get('app');
    }
    protected function getContactPhone()
    {
        return $this->get('contact-us')['phone']['value'];
    }
    public static function getMapApi()
    {
        return (new self)->getSingle('apis', 'google_map')['value'];
    }
    public static function getCommissionSettings()
    {
        return (new self)->get('advertisement');
    }
}
