<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use App\Providers\RouteServiceProvider;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_merchants_can_authenticate_using_the_login_screen()
    {
        $merchant = Merchant::factory()->create();

        $response = $this->post('/login', [
            'email' => $merchant->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated($this->guard);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_merchants_can_not_authenticate_with_invalid_password()
    {
        $merchant = Merchant::factory()->create();

        $this->post('/login', [
            'email' => $merchant->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
