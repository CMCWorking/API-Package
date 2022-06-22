<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Dingo\Api\Routing\Helpers;

class PaymentMethodV1Controller extends Controller
{
    use Helpers;

    public function index()
    {
        $payment_methods = PaymentMethod::paginate(10);

        return $this->response->paginator($payment_methods, new PaymentMethodTransformer());
    }
}
