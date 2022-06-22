<?php
namespace App\Http\Controllers\Api\CustomerInformation;

use App\Models\CustomerInformations;
use League\Fractal\TransformerAbstract;

class CustomerInformationTransformer extends TransformerAbstract
{
    public function transform(CustomerInformations $customer_information)
    {
        return [
            'name' => $customer_information['name'],
            'email' => $customer_information['email'],
            'phone' => $customer_information['phone'],
            'receive_promotion' => $customer_information['receive_promotion'],
            'addresses' => $customer_information->addresses,
        ];
    }
}
