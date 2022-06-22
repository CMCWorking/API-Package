<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->truncate();

        $type = ['Tiền mặt', 'Chuyển khoản', 'Thanh toán online'];

        foreach ($type as $value) {
            PaymentMethod::create([
                'name' => $value,
                'description' => 'Phương thức thanh toán bằng ' . $value,
            ]);
        }
    }
}
