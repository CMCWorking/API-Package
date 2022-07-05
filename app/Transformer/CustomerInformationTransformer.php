<?php
namespace App\Transformer;

use App\Models\CustomerInformation;
use League\Fractal\TransformerAbstract;

class CustomerInformationTransformer extends TransformerAbstract
{
    public function transform(CustomerInformation $customer_information)
    {
        return [
            'id' => $customer_information['id'],
            'name' => $customer_information['name'],
            'email' => $customer_information['email'],
            'phone' => $customer_information['phone'],
            'receive_promotion' => $customer_information['receive_promotion'],
            'login_engine' => $customer_information['login_engine'],
            'addresses' => $customer_information->addresses,
            'created_at' => date('Y-m-d', strtotime($customer_information['created_at'])),
        ];
    }
}
