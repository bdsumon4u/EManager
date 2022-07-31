<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['foo', 'bar'] as $key) {
            Tenant::query()->findOr($key, ['*'], fn () => Tenant::query()->create([
                'id' => $key,
            ])->domains()->create(['domain' => $key]));
        }
    }
}
