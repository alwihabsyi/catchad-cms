<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wifi;

class WifiController extends Controller
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
                'bssid' => 'required|string|unique:wifi,bssid',
                'ssid' => 'nullable|string',
                'frequency' => 'required|integer',
                'rssi' => 'required|integer',
                'device_id' => 'required|string|exists:devices,id',
            ]);

            $wifi = Wifi::create([
                'bssid' => $validated['bssid'],
                'ssid' => $validated['ssid'],
                'frequency' => $validated['frequency'],
                'rssi' => $validated['rssi'],
                'device_id' => $validated['device_id'],
            ]);

            return response()->json([
                'message' => 'Wifi record created successfully!',
                'wifi' => $wifi
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
    public function destroy(string $bssid)
    {
        try {
            $wifi = Wifi::where('bssid', $bssid)->first();
            if ($wifi) {
                $wifi->delete();
                return response()->json(['message' => 'Wifi record deleted successfully!'], 200);
            }

            return response()->json(['error' => 'Wifi record not found!'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAll()
    {
        try {
            Wifi::truncate();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
