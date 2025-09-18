<?php

namespace Tests\Domain\Service\Rules;

use App\Domain\Service\Rules\PositiveCost;
use Tests\TestCase;

class PositiveCostRuleTest extends TestCase
{
    public function test_passes_with_positive_cost(): void
    {
        $rule = new PositiveCost();
        $this->assertTrue($rule->passes('cost', 10));
    }

    public function test_fails_with_negative_cost(): void
    {
        $rule = new PositiveCost();
        $this->assertFalse($rule->passes('cost', -5));
    }
}
