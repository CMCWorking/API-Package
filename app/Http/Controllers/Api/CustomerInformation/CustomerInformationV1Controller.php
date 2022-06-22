<?php

namespace App\Http\Controllers\Api\CustomerInformation;

use App\Http\Controllers\Controller;
use App\Models\CustomerInformations;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerInformationV1Controller extends Controller
{
    use Helpers;

    public function index()
    {
        $customer_informations = CustomerInformations::paginate(10);

        return $this->response->paginator($customer_informations, new CustomerInformationTransformer());
    }

    public function show($id)
    {
        $customer_information = CustomerInformations::find($id);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function store(Request $request)
    {
        $customer_information = CustomerInformations::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'receive_promotion' => 0,
        ]);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function update(Request $request, $id)
    {
        $customer_information = CustomerInformations::find($id);

        $customer_information->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'receive_promotion' => $request->receive_promotion,
        ]);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function destroy($id)
    {
        $customer_information = CustomerInformations::find($id);

        $customer_information->delete();

        return $this->response->noContent();
    }
}
