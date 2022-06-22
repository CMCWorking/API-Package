<?php

namespace App\Http\Controllers\Api\CustomerInformation;

use App\Http\Controllers\Controller;
use App\Models\CustomerInformations;
use Dingo\Api\Routing\Helpers;

class CustomerInformationV1Controller extends Controller
{
    use Helpers;

    public function index()
    {
        $customer_informations = CustomerInformations::paginate(10);

        return $this->response->paginator($customer_informations, new CustomerInformationTransformer());
    }
}
