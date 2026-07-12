<?php

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol(): string
    {
        $currency = cache()->remember('active_currency', 3600, function () {
            return \App\Models\CurrencySetting::where('status', true)->first()
                ?? \App\Models\CurrencySetting::where('is_default', true)->first();
        });

        return $currency ? $currency->symbol : '$';
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice(float|int $amount): string
    {
        $currency = cache()->remember('active_currency', 3600, function () {
            return \App\Models\CurrencySetting::where('status', true)->first()
                ?? \App\Models\CurrencySetting::where('is_default', true)->first();
        });

        if (!$currency) {
            return '$' . number_format($amount, 2);
        }

        $converted = $amount * $currency->exchange_rate;

        $decimals = in_array($currency->currency_code, ['BDT', 'INR']) ? 0 : 2;

        return $currency->symbol . ' ' . number_format($converted, $decimals);
    }
}
