<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Providers\RouteServiceProvider;
use Hotash\Authable\Registrar;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_registration_screen_can_be_rendered()
    {
        if (! in_array(Features::registration(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled()
    {
        if (in_array(Features::registration(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_merchants_can_register()
    {
        if (! in_array(Features::registration(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'name' => 'Test Merchant',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        $this->assertAuthenticated($this->guard);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
