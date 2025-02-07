@extends('layout')

@section('content')
    <div class="mt-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Devices</h1>
                <p>List of CatchAd devices.</p>
            </div>
            <div class="rounded shadow bg-gray-100 py-1 px-2 cursor-pointer" onclick="confirmDelete()">
                <i class="fas fa-trash text-xl" style="color: red;"></i>
            </div>
        </div>

        <div class="mt-5 items-center h-[80vh] overflow-y-auto">
            @if ($devices->isEmpty())
                <div class="h-full flex items-center justify-center">
                    <p class="text-center text-gray-500">No Devices</p>
                </div>
            @else
                @foreach ($devices as $device)
                    <a href="{{ route('device.show', $device->id) }}">
                        <div class="w-full rounded-2xl overflow-hidden shadow-lg mb-4 bg-gray-100 px-6 py-4 flex justify-between items-center">
                            <div>
                                <h2 class="font-bold text-xl">{{ $device->name }}</h2>
                                <p class="text-gray-700 text-base">
                                    <strong>Brand:</strong> {{ $device->brand }}<br>
                                    <strong>Manufacturer:</strong> {{ $device->manufacturer }}<br>
                                    <strong>Device ID:</strong> {{ $device->id }}
                                </p>
                            </div>
                            <i class="fas fa-info-circle text-3xl"></i>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete() {
            const message = 'Are you sure you want to delete all CatchAd devices?'

            if (confirm(message)) {
                fetch(`/delete-devices`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Devices deleted successfully.");
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
