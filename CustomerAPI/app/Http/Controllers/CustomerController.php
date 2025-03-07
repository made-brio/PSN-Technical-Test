<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        return response()->json(Customer::all(), 200);
    }

    public function show($id) {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json($customer, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'gender' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:customers',
            'image' => 'nullable|string',
        ]);

        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    public function update(Request $request, $id) {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'title' => 'string',
            'name' => 'string',
            'gender' => 'string',
            'phone_number' => 'string',
            'email' => 'email|unique:customers,email,' . $id,
            'image' => 'nullable|string',
        ]);

        $customer->update($request->all());
        return response()->json($customer, 200);
    }

    public function destroy($id) {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
}

