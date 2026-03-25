<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $payload = $request->except('_token');
        $existingSettings = Setting::all()->keyBy('key');

        foreach ($payload as $key => $value) {
            $existing = $existingSettings->get($key);

            $type = $existing?->type ?? 'text';
            $group = $existing?->group ?? 'general';

            $this->settingService->set($key, $value ?? '', $type, $group);
        }

        return back()->with('success', 'Configurações salvas com sucesso!');
    }
}
