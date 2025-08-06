<?php

namespace Tests\Domain\Client\Rules;

use App\Domain\Client\Entities\Client;
use App\Domain\Client\Rules\UniqueClientEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniqueClientEmailRuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_when_email_exists(): void
    {
        Client::factory()->create(['email' => 'exists@example.com']);
        $rule = new UniqueClientEmail();
        $this->assertFalse($rule->passes('email', 'exists@example.com'));
    }

    public function test_passes_when_email_is_unique(): void
    {
        Client::factory()->create(['email' => 'exists@example.com']);
        $rule = new UniqueClientEmail();
        $this->assertTrue($rule->passes('email', 'new@example.com'));
    }
}
