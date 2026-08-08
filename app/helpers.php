<?php

if (!function_exists('get_currency_symbol')) {
    /**
     * Get currency symbol for a currency code.
     */
    function get_currency_symbol($code = 'GBP') {
        $code = strtoupper(trim($code ?? 'GBP'));
        $symbols = [
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            'BDT' => '৳',
            'INR' => '₹',
            'CAD' => 'CA$',
            'AUD' => 'A$',
            'MYR' => 'RM',
            'SGD' => 'S$',
            'AED' => 'AED',
            'SAR' => 'SAR',
        ];
        return $symbols[$code] ?? '$';
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency amount with currency code and symbol before amount.
     * Example: format_currency(100, 'USD') -> "USD $ 100.00"
     * Example: format_currency(-500, 'USD') -> "-USD $ 500.00"
     */
    function format_currency($amount, $code = 'GBP', $showCode = true) {
        $code = strtoupper(trim($code ?? 'GBP'));
        $symbol = get_currency_symbol($code);
        $num = floatval($amount ?? 0);
        $formatted = number_format(abs($num), 2);
        
        $prefix = ($num < 0) ? '-' : '';
        
        if ($showCode && $code) {
            return "{$prefix}{$code} {$symbol} {$formatted}";
        }
        return "{$prefix}{$symbol} {$formatted}";
    }
}
