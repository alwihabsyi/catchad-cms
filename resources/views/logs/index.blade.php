@extends('layout')

@section('content')
    <div class="px-6 py-4 mb-12">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Transmitter Data</h1>

        {{-- WiFi Filters --}}
        <h2 class="text-xl font-semibold mb-2 text-gray-700">WiFi Transmitters</h2>
        <div class="flex justify-between">
            <div class="flex gap-4 mb-6">
                <div class="custom-select-wrapper">
                    <select id="wifiDeviceName" class="custom-select">
                        <option value="">All Device Names</option>
                    </select>
                </div>
                <div class="custom-select-wrapper">
                    <select id="wifiManufacturer" class="custom-select">
                        <option value="">All Manufacturers</option>
                    </select>
                </div>
                <div class="custom-select-wrapper">
                    <select id="wifiSSID" class="custom-select">
                        <option value="">All SSID</option>
                    </select>
                </div>
            </div>
            <div>
                <input type="text" id="wifiSearch" placeholder="Search WiFi data..." class="border p-2 rounded">
            </div>
        </div>

        {{-- WiFi Table --}}
        <div class="overflow-x-auto rounded-lg">
            <table class="w-full bg-white shadow-md rounded-lg mb-6">
                <thead>
                    <tr class="bg-gray-800 text-white text-center">
                        <th class="px-5 py-3">Device Name</th>
                        <th class="px-5 py-3">Manufacturer</th>
                        <th class="px-5 py-3">Brand</th>
                        <th class="px-5 py-3">BSSID</th>
                        <th class="px-5 py-3">SSID</th>
                        <th class="px-5 py-3">RSSI</th>
                        <th class="px-5 py-3">Frequency</th>
                        <th class="px-5 py-3">Time</th>
                    </tr>
                </thead>
                <tbody id="wifiTableBody" class="divide-y divide-gray-200"></tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-2">
            <button id="prevWifi" class="pagination-btn">Previous</button>
            <span id="wifiPageInfo" class="text-gray-700"></span>
            <button id="nextWifi" class="pagination-btn">Next</button>
        </div>

        {{-- Bluetooth Filters --}}
        <h2 class="text-xl font-semibold mt-8 mb-2 text-gray-700">Bluetooth Transmitters</h2>
        <div class="flex justify-between">
            <div class="flex gap-4 mb-6">
                <div class="custom-select-wrapper">
                    <select id="bluetoothDeviceName" class="custom-select">
                        <option value="">All Device Names</option>
                    </select>
                </div>
                <div class="custom-select-wrapper">
                    <select id="bluetoothManufacturer" class="custom-select">
                        <option value="">All Manufacturers</option>
                    </select>
                </div>
            </div>
            <div>
                <input type="text" id="bluetoothSearch" placeholder="Search Bluetooth data..."
                    class="border p-2 rounded shadow">
            </div>
        </div>

        {{-- Bluetooth Table --}}
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="w-full bg-white">
                <thead>
                    <tr class="bg-gray-800 text-white text-center">
                        <th class="px-5 py-3">Device Name</th>
                        <th class="px-5 py-3">Manufacturer</th>
                        <th class="px-5 py-3">Brand</th>
                        <th class="px-5 py-3">MAC Address</th>
                        <th class="px-5 py-3">Transmitter Name</th>
                        <th class="px-5 py-3">RSSI</th>
                        <th class="px-5 py-3">Time</th>
                    </tr>
                </thead>
                <tbody id="bluetoothTableBody" class="divide-y divide-gray-200"></tbody>
            </table>
        </div>

        <div class="flex justify-between items-center mt-4">
            <button id="prevBluetooth" class="pagination-btn">Previous</button>
            <span id="bluetoothPageInfo" class="text-gray-700"></span>
            <button id="nextBluetooth" class="pagination-btn">Next</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let wifiPage = 1;
            let bluetoothPage = 1;
            const perPage = 5;


            function fetchFilters() {
                $.ajax({
                    url: "{{ route('wifi.filters') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#wifiDeviceName').append(data.devices.map(d =>
                            `<option value="${d}">${d}</option>`));
                        $('#wifiManufacturer').append(data.manufacturers.map(m =>
                            `<option value="${m}">${m}</option>`));
                        $('#wifiSSID').append(data.ssid.map(s =>
                            `<option value="${s}">${s}</option>`));
                    }
                });

                $.ajax({
                    url: "{{ route('bluetooth.filters') }}",
                    type: 'GET',
                    success: function(data) {
                        $('#bluetoothDeviceName').append(data.devices.map(d =>
                            `<option value="${d}">${d}</option>`));
                        $('#bluetoothManufacturer').append(data.manufacturers.map(m =>
                            `<option value="${m}">${m}</option>`));
                    }
                });
            }

            function loadTable(type, page) {
                let url = type === 'wifi' ? "{{ route('wifi.data') }}" : "{{ route('bluetooth.data') }}";
                let tableBody = type === 'wifi' ? "#wifiTableBody" : "#bluetoothTableBody";
                let pageInfo = type === 'wifi' ? "#wifiPageInfo" : "#bluetoothPageInfo";
                let prevBtn = type === 'wifi' ? "#prevWifi" : "#prevBluetooth";
                let nextBtn = type === 'wifi' ? "#nextWifi" : "#nextBluetooth";

                let filters = {
                    device_name: type === 'wifi' ? $('#wifiDeviceName').val() : $('#bluetoothDeviceName').val(),
                    manufacturer: type === 'wifi' ? $('#wifiManufacturer').val() : $('#bluetoothManufacturer')
                        .val(),
                    search_query: type === 'wifi' ? $('#wifiSearch').val() : $('#bluetoothSearch').val(),
                    ssid: type === 'wifi' ? $('#wifiSSID').val() : '',
                    page: page,
                    per_page: perPage
                };

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: filters,
                    success: function(response) {
                        let rows = response.data.length ? response.data.map(item => {
                            return type === 'wifi' ? `
                    <tr class="text-center">
                        <td class="px-5 py-3">${item.device?.name || '-'}</td>
                        <td class="px-5 py-3">${item.device?.manufacturer || '-'}</td>
                        <td class="px-5 py-3">${item.device?.brand || '-'}</td>
                        <td class="px-5 py-3">${item.bssid || '-'}</td>
                        <td class="px-5 py-3">${item.ssid || '-'}</td>
                        <td class="px-5 py-3">${item.rssi || '-'}</td>
                        <td class="px-5 py-3">${item.frequency || '-'}</td>
                        <td class="px-5 py-3">${item.updated_at || '-'}</td>
                    </tr>` : `
                    <tr class="text-center">
                        <td class="px-5 py-3">${item.device?.name || '-'}</td>
                        <td class="px-5 py-3">${item.device?.manufacturer || '-'}</td>
                        <td class="px-5 py-3">${item.device?.brand || '-'}</td>
                        <td class="px-5 py-3">${item.address || '-'}</td>
                        <td class="px-5 py-3">${item.name || '-'}</td>
                        <td class="px-5 py-3">${item.rssi || '-'}</td>
                        <td class="px-5 py-3">${item.updated_at || '-'}</td>
                    </tr>`;
                        }).join('') : `<tr><td colspan="8" class="text-center h-24 text-gray-500">No data available</td></tr>`;

                        $(tableBody).html(rows);
                        $(pageInfo).text(`Page ${page} of ${response.total_pages}`);
                        $(prevBtn).prop('disabled', page <= 1);
                        $(nextBtn).prop('disabled', page >= response.total_pages);
                    }
                });
            }


            fetchFilters();
            loadTable('wifi', wifiPage);
            loadTable('bluetooth', bluetoothPage);


            $('#wifiSearch, #bluetoothSearch').on('keyup', function() {
                let type = $(this).attr('id') === 'wifiSearch' ? 'wifi' : 'bluetooth';
                loadTable(type, 1);
            });

            $('#wifiDeviceName, #wifiManufacturer, #wifiSSID').change(() => loadTable('wifi', wifiPage = 1));
            $('#bluetoothDeviceName, #bluetoothManufacturer').change(() => loadTable('bluetooth', bluetoothPage =
                1));

            $('#nextWifi').click(() => loadTable('wifi', ++wifiPage));
            $('#prevWifi').click(() => loadTable('wifi', --wifiPage));

            $('#nextBluetooth').click(() => loadTable('bluetooth', ++bluetoothPage));
            $('#prevBluetooth').click(() => loadTable('bluetooth', --bluetoothPage));
        });
    </script>
@endsection

<style>
    .custom-select {
        appearance: none;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 12px;
        padding-right: 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .custom-select-wrapper {
        position: relative;
        display: inline-block;
    }

    .custom-select-wrapper::after {
        content: '▾';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: gray;
        font-size: 16px;
    }

    .pagination-btn {
        background-color: #ccc;
        padding: 8px 16px;
        border-radius: 6px;
        opacity: 1;
        transition: opacity 0.2s;
    }

    .pagination-btn:disabled {
        opacity: 0.5;
    }
</style>
