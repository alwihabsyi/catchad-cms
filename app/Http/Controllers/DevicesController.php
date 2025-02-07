<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\Bluetooth;
use App\Models\DeviceLog;
use App\Models\Wifi;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|string|unique:devices,id',
                'name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'manufacturer' => 'required|string|max:255',
            ]);

            $device = Device::create([
                'id' => $validated['id'],
                'name' => $validated['name'],
                'brand' => $validated['brand'],
                'manufacturer' => $validated['manufacturer'],
            ]);

            return response()->json([
                'type' => 'success',
                'message' => 'Device created successfully!',
                'device' => $device
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'type' => 'error',
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
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
        $device = Device::findOrFail($id);
        $bluetooth = Bluetooth::where('device_id', $id)->get();
        $wifi = Wifi::where('device_id', $id)->get();
        $logs = DeviceLog::where('device_id', $id)->orderByDesc('created_at')->get();

        return view('device.show', compact('device', 'bluetooth', 'wifi', 'logs'));
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
    public function destroy(string $id)
    {
        $device = Device::find($id);

        if (!$id) {
            return response()->json(['message' => 'Device not found.'], 404);
        }

        $device->delete();
        return response()->json(['message' => 'Device deleted successfully.'], 200);
    }

    public function deleteAll()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
            Device::truncate();
            Bluetooth::truncate();
            Wifi::truncate();
    
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
