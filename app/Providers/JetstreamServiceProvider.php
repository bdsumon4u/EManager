<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Seller;
use Hotash\Authable\Providers\AuthableServiceProvider;
use Hotash\Authable\Registrar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features as FortifyFeatures;
use Laravel\Jetstream\Features as JetstreamFeatures;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Registrar::$viewSpace = [$this, 'viewSpace'];

        Registrar::add('admin', Admin::class, [
            'fortify' => [
                // FortifyFeatures::registration(),
                FortifyFeatures::resetPasswords(),
                FortifyFeatures::emailVerification(),
                FortifyFeatures::updateProfileInformation(),
                FortifyFeatures::updatePasswords(),
                FortifyFeatures::twoFactorAuthentication([
                    'confirm' => true,
                    'confirmPassword' => true,
                    'window' => 0,
                ]),
            ],
            'jetstream' => [
                JetstreamFeatures::termsAndPrivacyPolicy(),
                JetstreamFeatures::profilePhotos(),
                JetstreamFeatures::api(),
                // JetstreamFeatures::teams(['invitations' => true]),
                JetstreamFeatures::accountDeletion(),
            ],
        ], [$this, 'viewSpace']);

        Registrar::add('merchant', Merchant::class, [
            'fortify' => [
                FortifyFeatures::registration(),
                FortifyFeatures::resetPasswords(),
                FortifyFeatures::emailVerification(),
                FortifyFeatures::updateProfileInformation(),
                FortifyFeatures::updatePasswords(),
                FortifyFeatures::twoFactorAuthentication([
                    'confirm' => true,
                    'confirmPassword' => true,
                    'window' => 0,
                ]),
            ],
            'jetstream' => [
                JetstreamFeatures::termsAndPrivacyPolicy(),
                JetstreamFeatures::profilePhotos(),
                JetstreamFeatures::api(),
                // JetstreamFeatures::teams(['invitations' => true]),
                JetstreamFeatures::accountDeletion(),
            ],
        ], [$this, 'viewSpace']);

        Registrar::add('seller', Seller::class, [
            'fortify' => [
                FortifyFeatures::registration(),
                FortifyFeatures::resetPasswords(),
                FortifyFeatures::emailVerification(),
                FortifyFeatures::updateProfileInformation(),
                FortifyFeatures::updatePasswords(),
                FortifyFeatures::twoFactorAuthentication([
                    'confirm' => true,
                    'confirmPassword' => true,
                    'window' => 0,
                ]),
            ],
            'jetstream' => [
                JetstreamFeatures::termsAndPrivacyPolicy(),
                JetstreamFeatures::profilePhotos(),
                JetstreamFeatures::api(),
                // JetstreamFeatures::teams(['invitations' => true]),
                JetstreamFeatures::accountDeletion(),
            ],
        ], [$this, 'viewSpace']);
    }

    public function viewSpace($guard): string
    {
        $namespace = '';
        $host = request()->getHost();

        if ($guard) {
            $namespace = Str::ucfirst($guard).'/';
            $host = Str::after($host, $guard.'.');
        }

        if (in_array($host, config('tenancy.central_domains'))) {
            return $namespace;
        }

        return 'Tenant/'.$namespace;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);

        AuthableServiceProvider::fortify();
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to read, create, and update.');
    }
}
