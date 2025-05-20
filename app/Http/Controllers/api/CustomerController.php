<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
            ->orderBy('first_name')
            ->get();
        return response()->json(['customers' => $customers]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_number' => ['required', 'string', 'max:15', 'unique:customers'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'email' => ['nullable', 'email', 'max:100']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $customer = new Customer();
        $customer->document_number = $request->document_number;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->address = $request->address;
        $customer->birthday = $request->birthday;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->save();

        return response()->json(['customer' => $customer], 201);
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json(['customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'document_number' => ['required', 'string', 'max:15', 'unique:customers,document_number,'.$id],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date'],
            'phone_number' => ['nullable', 'string', 'max:10'],
            'email' => ['nullable', 'email', 'max:100']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'Validation error',
                'errors' => $validator->errors(),
                'statusCode' => 400
            ], 400);
        }

        $customer->document_number = $request->document_number;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->address = $request->address;
        $customer->birthday = $request->birthday;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->save();

        return response()->json(['customer' => $customer]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();
        $customers = DB::table('customers')->get();
        return response()->json(['customers' => $customers, 'success' => true]);
    }
}