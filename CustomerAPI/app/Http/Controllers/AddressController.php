<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'address' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|integer',
        ]);

        $address = Address::create($request->all());
        return response()->json($address, 201);
    }

    public function update(Request $request, $id) {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $request->validate([
            'address' => 'string',
            'district' => 'string',
            'city' => 'string',
            'province' => 'string',
            'postal_code' => 'integer',
        ]);

        $address->update($request->all());
        return response()->json($address, 200);
    }

    public function destroy($id) {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete();
        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
