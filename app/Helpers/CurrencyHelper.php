<?php

declare(strict_types=1);


/**
 * Format a numeric value into a localized currency string.
 *
 * @param int|float|null $amount The amount to format
 * @param string $locale Locale identifier, e.g., en_US
 * @param string $currency ISO 4217 currency code, e.g., USD
 *
 * @return string Formatted currency string
 */
function format_currency(int|float|null $amount, string $locale = 'en_US', string $currency = 'USD'): string
{
    $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);

    return $formatter->formatCurrency($amount, $currency);
}
