<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_other_browser_sessions_can_be_logged_out()
    {
        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
    }
}
