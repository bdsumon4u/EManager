<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Hotash\Authable\Registrar;
use Laravel\Jetstream\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_merchant_accounts_can_be_deleted()
    {
        if (! in_array(Features::accountDeletion(), Registrar::features(guard: $this->guard, key: 'jetstream'))) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $response = $this->delete('/user', [
            'password' => 'password',
        ]);

        $this->assertNull($merchant->fresh());
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted()
    {
        if (! Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $response = $this->delete('/user', [
            'password' => 'wrong-password',
        ]);

        $this->assertNotNull($merchant->fresh());
    }
}
