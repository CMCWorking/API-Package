<?php
namespace App\Transformer;

use App\Models\PaymentMethod;
use League\Fractal\TransformerAbstract;

class PaymentMethodTransformer extends TransformerAbstract
{
    public function transform(PaymentMethod $payment_method)
    {
        return [
            'id' => $payment_method['id'],
            'name' => $payment_method['name'],
            'description' => $payment_method['description'],
        ];
    }
}
