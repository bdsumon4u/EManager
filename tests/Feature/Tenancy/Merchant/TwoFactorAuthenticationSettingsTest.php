<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Hotash\Authable\Registrar;
use Laravel\Fortify\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_two_factor_authentication_can_be_enabled()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->post('/user/two-factor-authentication');

        $this->assertNotNull($merchant->fresh()->two_factor_secret);
        $this->assertCount(8, $merchant->fresh()->recoveryCodes());
    }

    public function test_recovery_codes_can_be_regenerated()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');
        $this->post('/user/two-factor-recovery-codes');

        $merchant = $merchant->fresh();

        $this->post('/user/two-factor-recovery-codes');

        $this->assertCount(8, $merchant->recoveryCodes());
        $this->assertCount(8, array_diff($merchant->recoveryCodes(), $merchant->fresh()->recoveryCodes()));
    }

    public function test_two_factor_authentication_can_be_disabled()
    {
        if (! in_array(Features::twoFactorAuthentication(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Two factor authentication is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');

        $this->assertNotNull($merchant->fresh()->two_factor_secret);

        $this->delete('/user/two-factor-authentication');

        $this->assertNull($merchant->fresh()->two_factor_secret);
    }
}
