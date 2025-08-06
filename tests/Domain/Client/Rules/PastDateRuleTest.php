<?php

namespace Tests\Domain\Client\Rules;

use App\Domain\Client\Rules\PastDate;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PastDateRuleTest extends TestCase
{
    public function test_passes_with_past_date(): void
    {
        $rule = new PastDate();
        $this->assertTrue($rule->passes('birthday', '2000-01-01'));
    }

    public function test_fails_with_future_date(): void
    {
        $rule = new PastDate();
        $future = Carbon::now()->addDay()->toDateString();
        $this->assertFalse($rule->passes('birthday', $future));
    }
}
