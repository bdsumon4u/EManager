<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Hotash\Authable\Registrar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'admin';

    public function test_two_factor_authentication_can_be_enabled()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($user = Admin::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);
        $this->assertCount(8, $user->fresh()->recoveryCodes());
    }

    public function test_recovery_codes_can_be_regenerated()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($user = Admin::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');
        $this->post('/user/two-factor-recovery-codes');

        $user = $user->fresh();

        $this->post('/user/two-factor-recovery-codes');

        $this->assertCount(8, $user->recoveryCodes());
        $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
    }

    public function test_two_factor_authentication_can_be_disabled()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($user = Admin::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');

        $this->assertNotNull($user->fresh()->two_factor_secret);

        $this->delete('/user/two-factor-authentication');

        $this->assertNull($user->fresh()->two_factor_secret);
    }
}
