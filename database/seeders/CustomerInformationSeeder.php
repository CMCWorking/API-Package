<?php

namespace Database\Seeders;

use App\Models\CustomerInformation;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerInformationSeeder extends Seeder
{
    public function __construct(CustomerInformation $customer_information)
    {
        $this->customer_information = $customer_information;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_informations')->truncate();

        $engine = ['facebook', 'google', 'email'];

        for ($i = 0; $i <= 20; $i++) {
            $this->customer_information->create([
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail(),
                'phone' => '0' . $this->faker->randomNumber(5, true) . '' . $this->faker->randomNumber(5, true),
                'password' => Hash::make($this->faker->password()),
                'receive_promotion' => $this->faker->numberBetween(0, 1),
                'login_engine' => $engine[array_rand($engine)],
                'account_key' => $this->faker->sha1(),
                'created_at' => $this->faker->dateTimeBetween(now()->subDays($this->faker->numberBetween(1, 100)), 'now'),
            ]);
        }
    }
}
