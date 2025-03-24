<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wifi;
use Yajra\DataTables\Facades\DataTables;

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
                'bssid' => 'required|string',
                'ssid' => 'nullable|string',
                'frequency' => 'required|integer',
                'rssi' => 'required|integer',
                'device_id' => 'required|string|exists:devices,id',
            ]);

            $wifi = Wifi::updateOrCreate(
                ['bssid' => $validated['bssid']],
                [
                    'ssid' => $validated['ssid'] ?? 'unknown',
                    'frequency' => $validated['frequency'],
                    'rssi' => $validated['rssi'],
                    'device_id' => $validated['device_id'],
                ]
            );

            return response()->json([
                'message' => $wifi->wasRecentlyCreated
                    ? 'Wifi record created successfully!'
                    : 'Wifi record updated successfully!',
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

    public function getWiFiData(Request $request)
    {
        $sortColumn = $request->input('sort_column', 'updated_at');
        $sortOrder = $request->input('sort_order', 'asc');

        $query = Wifi::with('device')
            ->leftJoin('devices', 'devices.id', '=', 'wifi.device_id')
            ->select('wifi.*', 'devices.name as device_name', 'devices.manufacturer as device_manufacturer', 'devices.brand as device_manufacturer');;

        if ($request->device_name) {
            $query->whereHas('device', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->device_name . '%');
            });
        }

        if ($request->manufacturer) {
            $query->whereHas('device', function ($q) use ($request) {
                $q->where('manufacturer', 'like', '%' . $request->manufacturer . '%');
            });
        }

        if ($request->ssid) {
            $query->where('ssid', 'like', '%' . $request->ssid . '%');
        }

        if ($request->search_query) {
            $search = $request->search_query;
            $query->where(function ($q) use ($search) {
                $q->where('ssid', 'like', "%$search%")
                    ->orWhere('bssid', 'like', "%$search%")
                    ->orWhere('frequency', 'like', "%$search%")
                    ->orWhere('rssi', 'like', "%$search%")
                    ->orWhereHas('device', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('manufacturer', 'like', "%$search%");
                    });
            });
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('wifi.updated_at', [$request->start_date, $request->end_date]);
        }

        if (in_array($sortColumn, ['bssid', 'ssid', 'frequency', 'rssi', 'updated_at', 'created_at'])) {
            $query->orderBy("wifi.$sortColumn", $sortOrder);
        } elseif (in_array($sortColumn, ['device_name', 'device_manufacturer', 'device_brand'])) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $query->orderBy('wifi.updated_at', 'asc');
        }

        $perPage = $request->per_page ?? 5;
        $data = $query->paginate($perPage);

        $formattedData = collect($data->items())->map(function ($item) {
            return [
                'bssid' => $item->bssid,
                'ssid' => $item->ssid,
                'frequency' => $item->frequency,
                'rssi' => $item->rssi,
                'device_id' => $item->device_id,
                'device' => $item->device,
                'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'data' => $formattedData,
            'total_pages' => $data->lastPage(),
            'current_page' => $data->currentPage()
        ]);
    }

    public function getWiFiFilters()
    {
        $devices = Wifi::with('device')->get()->pluck('device.name')->unique()->values();
        $manufacturers = Wifi::with('device')->get()->pluck('device.manufacturer')->unique()->values();
        $ssid = Wifi::with('device')->get()->pluck('ssid')->unique()->values();

        return response()->json([
            'devices' => $devices,
            'manufacturers' => $manufacturers,
            'ssid' => $ssid
        ]);
    }
}
