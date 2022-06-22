<?php
namespace App\Http\Controllers\Api\PaymentMethod;

use App\Models\PaymentMethod;
use League\Fractal\TransformerAbstract;

class PaymentMethodTransformer extends TransformerAbstract
{
    public function transform(PaymentMethod $payment_method)
    {
        return [
            'name' => $payment_method['name'],
            'description' => $payment_method['description'],
        ];
    }
}
