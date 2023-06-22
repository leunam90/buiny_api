<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FiscalAddress;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query()->orderBy('first_name');

        if ($request->has('id')) {
            $query->where('first_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('last_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('sur_name', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('phone_number', 'LIKE', '%' . $request->id . '%');
            $query->orWhere('email', 'LIKE', '%' . $request->id . '%');
        }

        $customers = $query->get();

        $data = [];
        foreach ($customers as $customer) {
            $data[] = [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'sur_name' => $customer->sur_name,
                'phone_number' => $customer->phone_number,
                'email' => $customer->email,
                'address' => $customer->address
            ];
        }

        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $customer = new Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->sur_name = $request->sur_name;
            $customer->phone_number = $request->phone_number;
            $customer->email = $request->email;
            $customer->rfc = $request->rfc;
            $customer->fiscal_regimen = $request->fiscal_regimen;
            $customer->save();

            $address = new FiscalAddress();
            $address->street = $request->street;
            $address->ext_number = $request->ext_number;
            $address->int_number = $request->int_number;
            $address->zip_code = $request->zip_code;
            $address->neighborhood = $request->neighborhood;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->customer_id = $customer->id;
            $address->save();

            $data = [
                "message" => "Successfully created",
                "customer" => $customer
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                "error" => true,
                "message" => $ex->getMessage()
            ];
            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $request, Customer $customer)
    {
        try {
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->sur_name = $request->sur_name;
            $customer->phone_number = $request->phone_number;
            $customer->email = $request->email;
            $customer->rfc = $request->rfc;
            $customer->fiscal_regimen = $request->fiscal_regimen;
            $customer->save();

            $address = $customer->address;
            $address->street = $request->street;
            $address->ext_number = $request->ext_number;
            $address->int_number = $request->int_number;
            $address->zip_code = $request->zip_code;
            $address->neighborhood = $request->neighborhood;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->save();

            $data = [
                "message" => "Successfully updated",
                "customer" => $customer
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                "error" => true,
                "message" => $ex->getMessage()
            ];
            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            $data = [
                "message" => "Successfully deleted",
                "customer" => $customer
            ];

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $ex) {
            $data = [
                "error" => true,
                "message" => $ex->getMessage()
            ];
            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
