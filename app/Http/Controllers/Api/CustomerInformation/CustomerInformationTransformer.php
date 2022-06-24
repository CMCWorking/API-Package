<?php
namespace App\Http\Controllers\Api\CustomerInformation;

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
            'addresses' => $customer_information->addresses,
        ];
    }
}
