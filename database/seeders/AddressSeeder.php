<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CustomerInformation;
use Buihuycuong\Vnfaker\VNFaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('addresses')->truncate();

        $customers = CustomerInformation::get('id')->toArray();

        for ($i = 0; $i <= 10; $i++) {
            Address::create([
                'customer_id' => $customers[array_rand($customers)]['id'],
                'address' => 'address',
                'city_id' => rand(1, 99),
                'district_id' => rand(1, 99),
                'ward_id' => rand(1, 99),
                'name' => VNFaker::fullname(),
                'phone' => VNFaker::mobilephone(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
