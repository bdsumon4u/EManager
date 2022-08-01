<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merchant::query()->firstOrCreate([
            'email' => 'merchant@merchant.com',
        ], [
            'name' => 'Merchant',
            'password' => bcrypt('password'),
        ]);
    }
}
