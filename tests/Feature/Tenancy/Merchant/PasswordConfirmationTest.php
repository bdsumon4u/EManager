<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $merchant = Merchant::factory()->create();

        $response = $this->actingAs($merchant, $this->guard)->get('/user/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $merchant = Merchant::factory()->create();

        $response = $this->actingAs($merchant, $this->guard)->post('/user/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $merchant = Merchant::factory()->create();

        $response = $this->actingAs($merchant, $this->guard)->post('/user/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
