<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use Hotash\Authable\Registrar;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class DeleteApiTokenTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_api_tokens_can_be_deleted()
    {
        if (! in_array(Features::api(), Registrar::features(guard: $this->guard, key: 'jetstream'))) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $this->actingAs($merchant = Merchant::factory()->create(), $this->guard);

        $token = $merchant->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        $response = $this->delete('/user/api-tokens/'.$token->id);

        $this->assertCount(0, $merchant->fresh()->tokens);
    }
}
