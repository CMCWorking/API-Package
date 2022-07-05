<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CustomerInformation;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddressSeeder extends Seeder
{
    public function __construct(CustomerInformation $customer_information, Address $address)
    {
        $this->customer_information = $customer_information;
        $this->address = $address;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('addresses')->truncate();

        $customers = $this->customer_information->get('id')->toArray();

        for ($i = 0; $i <= 10; $i++) {
            $this->address->create([
                'customer_id' => $customers[array_rand($customers)]['id'],
                'address' => $this->faker->streetAddress(),
                'city_id' => $this->faker->randomNumber(3, false),
                'district_id' => $this->faker->randomNumber(3, false),
                'ward_id' => $this->faker->randomNumber(3, false),
                'name' => $this->faker->name,
                'phone' => '0' . $this->faker->randomNumber(5, true) . '' . $this->faker->randomNumber(5, true),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
