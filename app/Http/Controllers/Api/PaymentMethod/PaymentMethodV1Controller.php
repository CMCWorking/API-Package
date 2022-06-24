<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodAPIRequest;
use App\Models\PaymentMethod;
use Dingo\Api\Routing\Helpers;

class PaymentMethodV1Controller extends Controller
{
    use Helpers;

    public function __construct(PaymentMethod $payment_method)
    {
        $this->middleware('auth:sanctum');
        $this->payment_method = $payment_method;
    }

    public function index()
    {
        $payment_methods = $this->payment_method->paginate(10);

        return $this->response->paginator($payment_methods, new PaymentMethodTransformer());
    }

    public function show($id)
    {
        $payment_method = $this->payment_method->find($id);

        if (!$payment_method) {
            return $this->response->errorNotFound('Payment Method not found');
        }

        return $this->response->item($payment_method, new PaymentMethodTransformer());
    }

    public function store(PaymentMethodAPIRequest $request)
    {
        $payment_method = $this->payment_method->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response->item($payment_method, new PaymentMethodTransformer());
    }

    public function update(PaymentMethodAPIRequest $request, $id)
    {
        $payment_method = $this->payment_method->find($id);

        $payment_method->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response->array([
            'message' => 'Payment Method updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $payment_method = $this->payment_method->find($id);

        $payment_method->delete();

        return $this->response->array([
            'message' => 'Payment Method deleted successfully.',
        ]);
    }
}
