<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class CurrencyHelperTest extends TestCase
{
    public function test_formats_number_in_default_locale_and_currency(): void
    {
        $this->assertSame('$1,234.56', format_currency(1234.56));
    }

    public function test_formats_zero_value(): void
    {
        $this->assertSame('$0.00', format_currency(0));
    }

    public function test_formats_negative_value(): void
    {
        $this->assertSame('-$1,234.56', format_currency(-1234.56));
    }

    public function test_formats_different_locale_and_currency(): void
    {
        $this->assertSame('$1,234.56', format_currency(1234.56, 'es_MX', 'MXN'));
    }

    public function test_formats_french_locale_and_currency(): void
    {
        $this->assertSame("1\u{202F}234,56\u{00A0}€", format_currency(1234.56, 'fr_FR', 'EUR'));
    }

    public function test_throws_type_error_on_null_input(): void
    {
        $this->expectException(\TypeError::class);
        format_currency(null);
    }

    public function test_throws_type_error_on_string_input(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        format_currency('invalid');
    }

    public function test_throws_type_error_on_boolean_input(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        format_currency(true);
    }
}
