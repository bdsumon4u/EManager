<?php

namespace Tests\Feature\Tenancy\Merchant;

use Tests\RefreshTenantDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshTenantDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
