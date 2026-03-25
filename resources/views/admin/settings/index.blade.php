@extends('layouts.admin')

@section('title', 'Configuracoes')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">Configuracoes</h1>
    <p class="text-zinc-400">Gerencie dados gerais, pagamentos e e-mails transacionais</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
    @csrf

    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-6">Geral</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="site_name" class="block text-sm font-semibold mb-2">Nome da Loja</label>
                <input id="site_name" name="site_name" type="text" value="{{ old('site_name', optional($settings->get('general')?->firstWhere('key', 'site_name'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>

            <div>
                <label for="site_slogan" class="block text-sm font-semibold mb-2">Slogan</label>
                <input id="site_slogan" name="site_slogan" type="text" value="{{ old('site_slogan', optional($settings->get('general')?->firstWhere('key', 'site_slogan'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>

            <div class="md:col-span-2">
                <label for="site_description" class="block text-sm font-semibold mb-2">Descricao</label>
                <textarea id="site_description" name="site_description" rows="4"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">{{ old('site_description', optional($settings->get('general')?->firstWhere('key', 'site_description'))->value) }}</textarea>
            </div>

            <div>
                <label for="contact_email" class="block text-sm font-semibold mb-2">E-mail de Contato</label>
                <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', optional($settings->get('general')?->firstWhere('key', 'contact_email'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>

            <div>
                <label for="contact_phone" class="block text-sm font-semibold mb-2">Telefone de Contato</label>
                <input id="contact_phone" name="contact_phone" type="text" value="{{ old('contact_phone', optional($settings->get('general')?->firstWhere('key', 'contact_phone'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>
        </div>
    </div>

    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-6">Pagamentos (Asaas)</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="asaas_api_key" class="block text-sm font-semibold mb-2">API Key</label>
                <input id="asaas_api_key" name="asaas_api_key" type="text" value="{{ old('asaas_api_key', optional($settings->get('payment')?->firstWhere('key', 'asaas_api_key'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>

            <div>
                <label for="asaas_environment" class="block text-sm font-semibold mb-2">Ambiente</label>
                <select id="asaas_environment" name="asaas_environment"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
                    @php
                        $asaasEnv = old('asaas_environment', optional($settings->get('payment')?->firstWhere('key', 'asaas_environment'))->value ?? 'sandbox');
                    @endphp
                    <option value="sandbox" {{ $asaasEnv === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                    <option value="production" {{ $asaasEnv === 'production' ? 'selected' : '' }}>Producao</option>
                </select>
            </div>

            <div>
                <label for="asaas_webhook_token" class="block text-sm font-semibold mb-2">Webhook Token</label>
                <input id="asaas_webhook_token" name="asaas_webhook_token" type="text" value="{{ old('asaas_webhook_token', optional($settings->get('payment')?->firstWhere('key', 'asaas_webhook_token'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-zinc-800/50 space-y-4">
            @php
                $pix = old('payment_pix_enabled', optional($settings->get('payment')?->firstWhere('key', 'payment_pix_enabled'))->value);
                $card = old('payment_credit_card_enabled', optional($settings->get('payment')?->firstWhere('key', 'payment_credit_card_enabled'))->value);
                $boleto = old('payment_boleto_enabled', optional($settings->get('payment')?->firstWhere('key', 'payment_boleto_enabled'))->value);
            @endphp

            <div class="flex items-center">
                <input type="hidden" name="payment_pix_enabled" value="0">
                <input id="payment_pix_enabled" name="payment_pix_enabled" type="checkbox" value="1" {{ (string) $pix === '1' ? 'checked' : '' }} class="w-5 h-5 bg-black border border-zinc-800/50 rounded">
                <label for="payment_pix_enabled" class="ml-3 text-sm font-semibold">PIX habilitado</label>
            </div>

            <div class="flex items-center">
                <input type="hidden" name="payment_credit_card_enabled" value="0">
                <input id="payment_credit_card_enabled" name="payment_credit_card_enabled" type="checkbox" value="1" {{ (string) $card === '1' ? 'checked' : '' }} class="w-5 h-5 bg-black border border-zinc-800/50 rounded">
                <label for="payment_credit_card_enabled" class="ml-3 text-sm font-semibold">Cartao de credito habilitado</label>
            </div>

            <div class="flex items-center">
                <input type="hidden" name="payment_boleto_enabled" value="0">
                <input id="payment_boleto_enabled" name="payment_boleto_enabled" type="checkbox" value="1" {{ (string) $boleto === '1' ? 'checked' : '' }} class="w-5 h-5 bg-black border border-zinc-800/50 rounded">
                <label for="payment_boleto_enabled" class="ml-3 text-sm font-semibold">Boleto habilitado</label>
            </div>
        </div>
    </div>

    <div class="bg-zinc-950 border border-zinc-800/50 rounded p-6">
        <h2 class="text-xl font-bold mb-6">E-mail</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="mail_from_address" class="block text-sm font-semibold mb-2">Remetente (Endereco)</label>
                <input id="mail_from_address" name="mail_from_address" type="email" value="{{ old('mail_from_address', optional($settings->get('email')?->firstWhere('key', 'mail_from_address'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>

            <div>
                <label for="mail_from_name" class="block text-sm font-semibold mb-2">Remetente (Nome)</label>
                <input id="mail_from_name" name="mail_from_name" type="text" value="{{ old('mail_from_name', optional($settings->get('email')?->firstWhere('key', 'mail_from_name'))->value) }}"
                    class="w-full px-4 py-3 bg-black border border-zinc-800/50 rounded focus:outline-none focus:border-zinc-700 transition">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end">
        <button type="submit" class="px-8 py-3 bg-white text-black font-semibold rounded hover:bg-zinc-200 transition">
            Salvar Configuracoes
        </button>
    </div>
</form>
@endsection
