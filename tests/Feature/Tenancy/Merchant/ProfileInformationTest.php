<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $response = $this->put('/user/profile-information', [
            'name' => 'Test Name',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test Name', $merchant->fresh()->name);
        $this->assertEquals('test@example.com', $merchant->fresh()->email);
    }
}
