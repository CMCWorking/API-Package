<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function __construct(PaymentMethod $payment_method)
    {
        $this->payment_method = $payment_method;
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->truncate();

        $type = ['Cash on Delivery', 'Bank Transfer', 'Online payment'];

        foreach ($type as $value) {
            $this->payment_method->create([
                'name' => $value,
                'description' => $this->faker->paragraph(2),
            ]);
        }
    }
}
