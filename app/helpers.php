<?php

if (!function_exists('get_currency_symbol')) {
    /**
     * Get currency symbol for a currency code or symbol string.
     */
    function get_currency_symbol($code = 'GBP') {
        if (empty($code)) {
            return '£';
        }
        $codeStr = trim($code);
        $upper = strtoupper($codeStr);

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

        if (isset($symbols[$upper])) {
            return $symbols[$upper];
        }

        if (in_array($codeStr, $symbols, true)) {
            return $codeStr;
        }

        if (preg_match('/\(([^)]+)\)/', $codeStr, $matches)) {
            return trim($matches[1]);
        }

        foreach ($symbols as $c => $s) {
            if (str_contains($upper, $c)) {
                return $s;
            }
            if (str_contains($codeStr, $s)) {
                return $s;
            }
        }

        return $codeStr;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency amount with currency code and matching symbol before amount.
     * Example: format_currency(100, 'GBP') -> "GBP £ 100.00"
     * Example: format_currency(100, 'USD') -> "USD $ 100.00"
     * Example: format_currency(100, 'BDT') -> "BDT ৳ 100.00"
     */
    function format_currency($amount, $code = 'GBP', $showCode = true) {
        $codeRaw = trim($code ?? 'GBP');
        $symbol = get_currency_symbol($codeRaw);
        
        $cleanCode = strtoupper(trim(preg_replace('/\s*\(.*?\)/', '', $codeRaw)));
        if ($cleanCode === $symbol) {
            $cleanCode = '';
        }

        $num = floatval($amount ?? 0);
        $formatted = number_format(abs($num), 2);
        $prefix = ($num < 0) ? '-' : '';

        if ($showCode && !empty($cleanCode) && $cleanCode !== $symbol) {
            return "{$prefix}{$cleanCode} {$symbol} {$formatted}";
        }
        return "{$prefix}{$symbol} {$formatted}";
    }
}
