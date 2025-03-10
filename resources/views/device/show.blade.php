@extends('layout')

@section('content')
    <div class="px-4">
        <a href="{{ route('logs.show', $device->id) }}">
            <div class="w-full rounded-2xl overflow-hidden shadow-md mb-4 bg-gray-100 px-6 py-4 flex items-center gap-3 mt-6">
                <i class="fas fa-clipboard text-xl"></i>
                <h2 class="font-bold text-xl">Device Report</h2>
            </div>
        </a>

        <div class="h-auto sm:h-[80vh] flex flex-col sm:flex-row justify-between gap-5 my-5">
            <div class="w-full sm:w-1/2 flex flex-col justify-between rounded-2xl shadow-md p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">BLE Devices</h1>
                        <p>List of scanned BLE devices.</p>
                    </div>
                    <div class="rounded shadow bg-gray-100 py-1 px-2 cursor-pointer" onclick="confirmDelete('bluetooth')">
                        <i class="fas fa-trash text-xl" style="color: red;"></i>
                    </div>
                </div>

                <div class="mt-3 h-[35vh] sm:h-[65vh] overflow-y-auto">
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
                                <p><strong>Timestamp:</strong> {{ $device->updated_at }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="w-full sm:w-1/2 flex flex-col justify-between rounded-2xl shadow-md p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">WiFi Devices</h1>
                        <p>List of scanned WiFi devices.</p>
                    </div>
                    <div class="rounded shadow bg-gray-100 py-1 px-2 cursor-pointer" onclick="confirmDelete('wifi')">
                        <i class="fas fa-trash text-xl" style="color: red;"></i>
                    </div>
                </div>

                <div class="mt-3 h-[35vh] sm:h-[65vh] overflow-y-auto">
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
                                <p><strong>Timestamp:</strong> {{ $device->updated_at }}</p>
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
