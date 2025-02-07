<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bluetooth;

class BluetoothController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'address' => 'required|string|unique:bluetooth,address',
                'name' => 'nullable|string',
                'manufacturer' => 'required|string',
                'rssi' => 'required|integer',
                'device_id' => 'required|string|exists:devices,id',
            ]);

            $bluetooth = Bluetooth::create([
                'address' => $validated['address'],
                'name' => $validated['name'],
                'manufacturer' => $validated['manufacturer'],
                'rssi' => $validated['rssi'],
                'device_id' => $validated['device_id'],
            ]);

            return response()->json([
                'message' => 'Bluetooth record created successfully!',
                'bluetooth' => $bluetooth
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $address)
    {
        try {
            $bluetooth = Bluetooth::where('address', $address)->first();
            if ($bluetooth) {
                $bluetooth->delete();
                return response()->json(['message' => 'Bluetooth record deleted successfully!'], 200);
            }

            return response()->json(['error' => 'Bluetooth record not found!'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAll()
    {
        try {
            Bluetooth::truncate();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
