<?php

namespace Tests\Feature\Tenancy\Admin;

use App\Models\Admin;
use Hotash\Authable\Registrar;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\RefreshTenantDatabase as RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $guard = 'admin';

    protected bool $tenancy = true;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        if (! in_array(Features::resetPasswords(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Password updates are not enabled.');
        }

        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        if (! in_array(Features::resetPasswords(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Password updates are not enabled.');
        }

        Notification::fake();

        $admin = Admin::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $admin->email,
        ]);

        Notification::assertSentTo($admin, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        if (! in_array(Features::resetPasswords(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Password updates are not enabled.');
        }

        Notification::fake();

        $admin = Admin::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $admin->email,
        ]);

        Notification::assertSentTo($admin, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        if (! in_array(Features::resetPasswords(), Registrar::features(guard: $this->guard, key: 'fortify'))) {
            return $this->markTestSkipped('Password updates are not enabled.');
        }

        Notification::fake();

        $admin = Admin::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $admin->email,
        ]);

        Notification::assertSentTo($admin, ResetPassword::class, function ($notification) use ($admin) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $admin->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
