<?php

namespace App\Http\Controllers\Api\CustomerInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerInformationAPIRequest;
use App\Models\CustomerInformation;
use App\Transformer\CustomerInformationTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CustomerInformationV1Controller extends Controller
{
    use Helpers;

    public function __construct(CustomerInformation $customer_information)
    {
        $this->middleware('auth:sanctum');
        $this->customer_information = $customer_information;
        $this->page = 10;
    }

    public function index(Request $request)
    {
        $customer_informations = $this->customer_information->filter($request->all())->paginate($request->paginate ?? $this->page);

        if ($customer_informations->count() < 1) {
            throw new AccessDeniedHttpException('No data found');
        }

        return $this->response->paginator($customer_informations, new CustomerInformationTransformer());
    }

    public function show($id)
    {
        $customer_information = $this->customer_information->find($id);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function store(CustomerInformationAPIRequest $request)
    {
        if (!auth()->user()->can('create-customer-informations')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to create customer informations.');
        }

        $customer_information = $this->customer_information->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'receive_promotion' => $request->receive_promotion ?? 0,
        ]);

        return $this->response->item($customer_information, new CustomerInformationTransformer());
    }

    public function update(CustomerInformationAPIRequest $request, $id)
    {
        $customer_information = $this->customer_information->find($id);

        if (!$customer_information) {
            return $this->response->errorNotFound('Customer information not found');
        }

        if (!auth()->user()->can('update-customer-informations')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to update customer informations.');
        }

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

        if (!$customer_information) {
            return $this->response->errorNotFound('Customer information not found');
        }

        if (!auth()->user()->can('delete-customer-informations')) {
            return $this->response->AccessDeniedHttpException('You are not allowed to delete customer informations.');
        }

        $customer_information->delete();

        return $this->response->noContent();
    }

    public function search(Request $request)
    {
        $customer_informations = $this->customer_information->filter()->paginate($request->paginate ?? $this->page);

        return $this->response->paginator($customer_informations, new CustomerInformationTransformer());

        // if ($customer_informations->count() < 1) {
        //     return $this->response->errorNotFound('No data found');
        // }

        // return $this->response->paginator($customer_informations, new CustomerInformationTransformer());
    }
}
