@extends('layout')

@section('content')
    <div>
        <h1 class="text-2xl font-bold mt-4">Device Log</h1>
        <div
            class="w-full h-64 bg-gray-50 shadow text-sm text-gray-500 font-mono p-4 rounded-lg shadow-md overflow-y-auto mt-2">
            <div id="logContainer" class="space-y-2">
                @forelse($logs as $log)
                    <p>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }} - {{ $log->log_message }}</p>
                @empty
                    <p class="text-gray-500">No logs available.</p>
                @endforelse
            </div>
        </div>

        <div class="h-[80vh] flex flex-row justify-between gap-5 my-4">
            <div class="w-1/2 flex flex-col justify-between rounded-2xl shadow-md p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">BLE Devices</h1>
                        <p>List of scanned BLE devices.</p>
                    </div>
                    <div class="rounded shadow bg-gray-100 py-1 px-2 cursor-pointer" onclick="confirmDelete('bluetooth')">
                        <i class="fas fa-trash text-xl" style="color: red;"></i>
                    </div>
                </div>

                <div class="h-[65vh] overflow-y-auto">
                    @if ($bluetooth->isEmpty())
                        <div class="h-full flex items-center justify-center">
                            <p class="text-center text-gray-500">No Bluetooth Devices</p>
                        </div>
                    @else
                        @foreach ($bluetooth as $device)
                            <div class="mb-4 p-4 rounded-lg shadow-md bg-gray-100">
                                <p><strong>Name:</strong> {{ $device->name }}</p>
                                <p><strong>Address:</strong> {{ $device->address }}</p>
                                <p><strong>Manufacturer:</strong> {{ $device->manufacturer }}</p>
                                <p><strong>RSSI:</strong> {{ $device->rssi }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="w-1/2 flex flex-col justify-between rounded-2xl shadow-md p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">WiFi Devices</h1>
                        <p>List of scanned WiFi devices.</p>
                    </div>
                    <div class="rounded shadow bg-gray-100 py-1 px-2 cursor-pointer" onclick="confirmDelete('wifi')">
                        <i class="fas fa-trash text-xl" style="color: red;"></i>
                    </div>
                </div>

                <div class="h-[65vh] overflow-y-auto">
                    @if ($wifi->isEmpty())
                        <div class="h-full flex items-center justify-center">
                            <p class="text-center text-gray-500">No WiFi Devices</p>
                        </div>
                    @else
                        @foreach ($wifi as $device)
                            <div class="mb-4 p-4 rounded-lg shadow-md bg-gray-100">
                                <p><strong>SSID:</strong> {{ $device->ssid }}</p>
                                <p><strong>BSSID:</strong> {{ $device->bssid }}</p>
                                <p><strong>Frequency:</strong> {{ $device->frequency }}</p>
                                <p><strong>RSSI:</strong> {{ $device->rssi }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(type) {
            const message = type === 'bluetooth' ?
                'Are you sure you want to delete all Bluetooth devices?' :
                'Are you sure you want to delete all WiFi devices?';

            if (confirm(message)) {
                fetch(`/delete-${type}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            alert(type.charAt(0).toUpperCase() + type.slice(1) + " devices deleted successfully.");
                            location.reload();
                        } else {
                            alert('Error deleting devices.');
                        }
                    })
                    .catch(error => {
                        alert('Error: ' + error);
                    });
            }
        }
    </script>
@endsection
