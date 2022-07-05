<?php

namespace Database\Seeders;

use App\Models\Status;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function __construct(Status $status)
    {
        $this->status = $status;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->truncate();

        $className = ['danger', 'success', 'warning', 'info'];
        $type = ['order_status', 'payment_status', 'shipping_status'];

        for ($i = 1; $i <= 5; $i++) {
            $this->status->create([
                'name' => $this->faker->words(3, true),
                'description' => $this->faker->words(3, true),
                'classname' => $className[array_rand($className)],
                'type' => $type[array_rand($type)],
            ]);
        }
    }
}
