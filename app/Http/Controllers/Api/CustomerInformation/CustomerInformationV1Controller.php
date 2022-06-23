<?php

namespace App\Http\Controllers\Api\CustomerInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerInformationAPIRequest;
use App\Models\CustomerInformation;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Hash;

class CustomerInformationV1Controller extends Controller
{
    use Helpers;

    public function __construct(CustomerInformation $customer_information)
    {
        $this->middleware('auth:sanctum');
        $this->customer_information = $customer_information;
    }

    public function index()
    {
        $customer_informations = $this->customer_information->paginate(10);

        return $this->response->paginator($customer_informations, new CustomerInformationTransformer());
    }

    public function show($id)
    {
        $customer_information = $this->customer_information->find($id);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function store(CustomerInformationAPIRequest $request)
    {
        $customer_information = $this->customer_information->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'receive_promotion' => 0,
        ]);

        return $this->response->array([
            'message' => 'Customer Information created successfully.',
        ]);
    }

    public function update(CustomerInformationAPIRequest $request, $id)
    {
        $customer_information = $this->customer_information->find($id);

        $customer_information->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'receive_promotion' => $request->receive_promotion,
        ]);

        return $this->response->array([
            'message' => 'Customer information updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $customer_information = $this->customer_information->find($id);

        $customer_information->delete();

        return $this->response->noContent();
    }
}
