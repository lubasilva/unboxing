<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function get(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }

    public function set(string $key, $value, string $type = 'text', string $group = 'general'): void
    {
        Setting::set($key, $value, $type, $group);
    }

    public function getAll(string $group = null): array
    {
        $query = Setting::query();

        if ($group) {
            $query->where('group', $group);
        }

        return $query->get()->pluck('value', 'key')->toArray();
    }

    public function getByGroup(): array
    {
        return Setting::all()
            ->groupBy('group')
            ->map(fn ($settings) => $settings->pluck('value', 'key'))
            ->toArray();
    }
}
