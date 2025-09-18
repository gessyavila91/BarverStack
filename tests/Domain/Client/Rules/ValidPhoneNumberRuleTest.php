<?php

namespace Tests\Domain\Client\Rules;

use App\Domain\Client\Rules\ValidPhoneNumber;
use Tests\TestCase;

class ValidPhoneNumberRuleTest extends TestCase
{
    public function test_passes_with_valid_number(): void
    {
        $rule = new ValidPhoneNumber();
        $this->assertTrue($rule->passes('phone', '+123-456-7890'));
    }

    public function test_fails_with_invalid_number(): void
    {
        $rule = new ValidPhoneNumber();
        $this->assertFalse($rule->passes('phone', 'abc'));
    }
}
