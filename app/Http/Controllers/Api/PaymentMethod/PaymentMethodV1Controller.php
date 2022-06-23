<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class PaymentMethodV1Controller extends Controller
{
    use Helpers;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $payment_methods = PaymentMethod::paginate(10);

        return $this->response->paginator($payment_methods, new PaymentMethodTransformer());
    }

    public function show($id)
    {
        $payment_method = PaymentMethod::find($id);

        return $this->response->item($payment_method, new PaymentMethodTransformer());
    }

    public function store(Request $request)
    {
        $payment_method = PaymentMethod::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response->created();
    }

    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethod::find($id);

        $payment_method->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return $this->response->item($payment_method, new PaymentMethodTransformer());
    }

    public function destroy($id)
    {
        $payment_method = PaymentMethod::find($id);

        $payment_method->delete();

        return $this->response->noContent();
    }
}
