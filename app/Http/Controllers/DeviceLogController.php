<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceLog;

class DeviceLogController extends Controller
{
    public function index($deviceId)
    {
        $logs = DeviceLog::where('device_id', $deviceId)
            ->latest()
            ->take(300)
            ->get();

        return view('logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'log_message' => 'required|string',
                'device_id' => 'required|exists:devices,id',
            ]);

            $deviceId = $request->device_id;

            if (DeviceLog::where('device_id', $deviceId)->count() >= 300) {
                DeviceLog::where('device_id', $deviceId)
                    ->oldest()
                    ->first()
                    ?->delete();
            }

            DeviceLog::create([
                'log_message' => $request->log_message,
                'device_id' => $deviceId,
            ]);

            return response()->json(['success' => true, 'message' => 'Log stored successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
