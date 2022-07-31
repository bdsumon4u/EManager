<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Hotash\Authable\Registrar;
use Laravel\Jetstream\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_api_tokens_can_be_created()
    {
        if (! in_array(Features::api(), Registrar::features(guard: $this->guard, key: 'jetstream'))) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $response = $this->post('/user/api-tokens', [
            'name' => 'Test Token',
            'permissions' => [
                'read',
                'update',
            ],
        ]);

        $this->assertCount(1, $merchant->fresh()->tokens);
        $this->assertEquals('Test Token', $merchant->fresh()->tokens->first()->name);
        $this->assertTrue($merchant->fresh()->tokens->first()->can('read'));
        $this->assertFalse($merchant->fresh()->tokens->first()->can('delete'));
    }
}
