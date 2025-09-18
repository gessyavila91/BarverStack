<?php

namespace Tests\Domain\Barbershop\Rules;

use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Barbershop\Rules\UniqueBarbershopName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniqueBarbershopNameRuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_when_name_exists(): void
    {
        Barbershop::factory()->create(['name' => 'Existing']);
        $rule = new UniqueBarbershopName();
        $this->assertFalse($rule->passes('name', 'Existing'));
    }

    public function test_passes_when_name_is_unique(): void
    {
        Barbershop::factory()->create(['name' => 'Existing']);
        $rule = new UniqueBarbershopName();
        $this->assertTrue($rule->passes('name', 'New Shop'));
    }
}
