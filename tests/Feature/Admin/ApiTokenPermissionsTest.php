<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Hotash\Authable\Registrar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class ApiTokenPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'admin';

    public function test_api_token_permissions_can_be_updated()
    {
        if (! in_array(Features::api(), Registrar::features(guard: $this->guard, key: 'jetstream'))) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $this->actingAs($user = Admin::factory()->create(), $this->guard);

        $token = $user->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        $response = $this->put('/user/api-tokens/'.$token->id, [
            'name' => $token->name,
            'permissions' => [
                'delete',
                'missing-permission',
            ],
        ]);

        $this->assertTrue($user->fresh()->tokens->first()->can('delete'));
        $this->assertFalse($user->fresh()->tokens->first()->can('read'));
        $this->assertFalse($user->fresh()->tokens->first()->can('missing-permission'));
    }
}
