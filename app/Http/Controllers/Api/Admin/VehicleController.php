<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        return response()->json(Vehicle::latest()->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'type'         => 'required|in:mobil,motor',
            'price_per_day'=> 'required|numeric|min:0',
            'status'       => 'required|in:tersedia,tidak tersedia',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = Vehicle::create($request->all());
        return response()->json($vehicle, 201);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'type'         => 'required|in:mobil,motor',
            'price_per_day'=> 'required|numeric|min:0',
            'status'       => 'required|in:tersedia,tidak tersedia',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle->update($request->all());
        return response()->json($vehicle);
    }

    public function destroy($id)
    {
        Vehicle::findOrFail($id)->delete();
        return response()->json(['message' => 'Kendaraan dihapus']);
    }
}