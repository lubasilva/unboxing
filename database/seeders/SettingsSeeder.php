<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Unboxing', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_slogan', 'value' => 'Abra. Descubra.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Estilo urbano premium. Óculos, tênis e streetwear.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'contato@unboxing.com.br', 'type' => 'email', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '(61) 99999-9999', 'type' => 'text', 'group' => 'general'],
            
            // ASAAS
            ['key' => 'asaas_api_key', 'value' => '', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'asaas_environment', 'value' => 'sandbox', 'type' => 'select', 'group' => 'payment'],
            ['key' => 'asaas_webhook_token', 'value' => '', 'type' => 'text', 'group' => 'payment'],
            
            // Payment Methods
            ['key' => 'payment_pix_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'payment_credit_card_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'payment_boleto_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'payment'],
            
            // Email
            ['key' => 'mail_from_address', 'value' => 'noreply@unboxing.com.br', 'type' => 'email', 'group' => 'email'],
            ['key' => 'mail_from_name', 'value' => 'Unboxing', 'type' => 'text', 'group' => 'email'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
