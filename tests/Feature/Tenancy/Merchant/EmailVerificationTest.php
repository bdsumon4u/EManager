<?php

namespace Tests\Feature\Tenancy\Merchant;

use App\Models\Merchant;
use App\Providers\RouteServiceProvider;
use Hotash\Authable\Registrar;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'merchant';

    protected bool $tenancy = true;

    public function test_email_verification_screen_can_be_rendered()
    {
        if (! in_array(Features::emailVerification(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Email verification not enabled.');
        }

        $merchant = Merchant::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($merchant, $this->guard)->get('/email/verify');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        if (! in_array(Features::emailVerification(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Email verification not enabled.');
        }

        Event::fake();

        $merchant = Merchant::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $merchant->id, 'hash' => sha1($merchant->email)]
        );

        $response = $this->actingAs($merchant, $this->guard)->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($merchant->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_email_can_not_verified_with_invalid_hash()
    {
        if (! in_array(Features::emailVerification(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Email verification not enabled.');
        }

        $merchant = Merchant::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $merchant->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($merchant, $this->guard)->get($verificationUrl);

        $this->assertFalse($merchant->fresh()->hasVerifiedEmail());
    }
}
