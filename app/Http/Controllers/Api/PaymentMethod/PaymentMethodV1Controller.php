<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethodAPIRequest;
use App\Models\PaymentMethod;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PaymentMethodV1Controller extends Controller
{
    use Helpers;

    public function __construct(PaymentMethod $payment_method)
    {
        $this->middleware('auth:sanctum');
        $this->payment_method = $payment_method;
        $this->page = 10;
    }

    public function index(Request $request)
    {
        $payment_methods = $this->payment_method->filter($request->all())->paginate($request->paginate ?? $this->page);

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
        if (!auth()->user()->can('create-payment-methods')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create payment methods.');
        }

        $payment_method = $this->payment_method->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response->item($payment_method, new PaymentMethodTransformer());
    }

    public function update(PaymentMethodAPIRequest $request, $id)
    {
        $payment_method = $this->payment_method->find($id);

        if (!$payment_method) {
            return $this->response->errorNotFound('Payment Method not found');
        }

        if (!auth()->user()->can('update-payment-methods')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to update payment methods.');
        }

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

        if (!$payment_method) {
            return $this->response->errorNotFound('Payment Method not found');
        }

        if (!auth()->user()->can('delete-payment-methods')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete payment methods.');
        }

        $payment_method->delete();

        return $this->response->array([
            'message' => 'Payment Method deleted successfully.',
        ]);
    }
}
