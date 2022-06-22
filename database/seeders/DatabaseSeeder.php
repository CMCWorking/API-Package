<?php

namespace Database\Seeders;

use Database\Seeders\AddressSeeder;
use Database\Seeders\CustomerInformationSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CustomerInformationSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
