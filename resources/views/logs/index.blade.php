@extends('layout')

@section('content')
    <div class="container px-6 py-4 mb-12">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Transmitter Data</h1>

        {{-- WiFi Filters --}}
        <h2 class="text-xl font-semibold mb-2 text-gray-700">WiFi Transmitters</h2>
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
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
                    <select id="wifiSSID" class="w-full custom-select">
                        <option value="">All SSID</option>
                    </select>
                </div>
                <div class="flex gap-2 items-center">
                    <input type="text" id="wifiDateRange" placeholder="Date Range.."
                        class="w-full sm:w-64 h-full border border-[#ccc] p-2 rounded" readonly>
                </div>
            </div>
            <div>
                <input type="text" id="wifiSearch" placeholder="Search WiFi data..."
                    class="w-full sm:w-fit border p-2 rounded">
            </div>
        </div>

        {{-- WiFi Table --}}
        <div class="w-full overflow-x-auto rounded-lg mt-3">
            <table class="w-full bg-white shadow-md rounded-lg mb-6">
                <thead>
                    <tr class="bg-gray-800 text-white text-center">
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="device_name" data-order="asc">Device
                            Name <span class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="device_manufacturer" data-order="asc">
                            Manufacturer <span class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="brand" data-order="asc">Brand <span
                                class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="bssid" data-order="asc">BSSID <span
                                class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="ssid" data-order="asc">SSID <span
                                class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="rssi" data-order="asc">RSSI <span
                                class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="frequency" data-order="asc">Frequency
                            <span class="sort-icon">⬍</span>
                        </th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="updated_at" data-order="asc">Time
                            <span class="sort-icon">⬍</span>
                        </th>
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
        <div class="flex flex-col sm:flex-row sm:justify-between">
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
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
                <div class="flex gap-2 items-center">
                    <input type="text" id="bluetoothDateRange" placeholder="Date Range.."
                        class="w-full sm:w-64 h-full border border-[#ccc] p-2 rounded" readonly>
                </div>
            </div>
            <div>
                <input type="text" id="bluetoothSearch" placeholder="Search Bluetooth data..."
                    class="w-full border p-2 rounded shadow">
            </div>
        </div>

        {{-- Bluetooth Table --}}
        <div class="overflow-x-auto shadow-md rounded-lg mt-3">
            <table class="w-full bg-white">
                <thead>
                    <tr class="bg-gray-800 text-white text-center">
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="device_name" data-order="asc">Device
                            Name <span class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="device_manufacturer" data-order="asc">
                            Manufacturer <span class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="device_brand" data-order="asc">
                            Brand
                            <span class="sort-icon">⬍</span>
                        </th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="address" data-order="asc">MAC
                            Address
                            <span class="sort-icon">⬍</span>
                        </th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="name" data-order="asc">Transmitter
                            Name <span class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="rssi" data-order="asc">RSSI <span
                                class="sort-icon">⬍</span></th>
                        <th class="px-5 py-3 cursor-pointer sort-column" data-column="updated_at" data-order="asc">Time
                            <span class="sort-icon">⬍</span>
                        </th>
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

            // START DATE PICKER
            $('#wifiDateRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD MMM YYYY'
                },
                maxSpan: {
                    days: 30
                }
            });

            $('#wifiDateRange').on('apply.daterangepicker', function(ev, picker) {
                const startDate = picker.startDate.format('YYYY-MM-DD 00:00:00');
                const endDate = picker.endDate.format('YYYY-MM-DD 23:59:59');
                $(this).val(
                    `${picker.startDate.format('DD MMM YYYY')} - ${picker.endDate.format('DD MMM YYYY')}`
                );

                loadTable('wifi', 1);
            });

            $('#wifiDateRange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                loadTable('wifi', 1);
            });

            $('#bluetoothDateRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD MMM YYYY'
                },
                maxSpan: {
                    days: 30
                }
            });

            $('#bluetoothDateRange').on('apply.daterangepicker', function(ev, picker) {
                const startDate = picker.startDate.format('YYYY-MM-DD 00:00:00');
                const endDate = picker.endDate.format('YYYY-MM-DD 23:59:59');
                $(this).val(
                    `${picker.startDate.format('DD MMM YYYY')} - ${picker.endDate.format('DD MMM YYYY')}`
                    );

                loadTable('bluetooth', 1);
            });

            $('#bluetoothDateRange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                loadTable('bluetooth', 1);
            });
            // END DATE PICKER

            // FETCH FILTER
            function fetchFilters() {
                $.ajax({
                    url: "/api/wifi/filters",
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
                    url: "/api/bluetooth/filters",
                    type: 'GET',
                    success: function(data) {
                        $('#bluetoothDeviceName').append(data.devices.map(d =>
                            `<option value="${d}">${d}</option>`));
                        $('#bluetoothManufacturer').append(data.manufacturers.map(m =>
                            `<option value="${m}">${m}</option>`));
                    }
                });
            }

            // LOAD TABLE
            function loadTable(type, page, sortColumn = 'updated_at', sortOrder = 'asc', icon = null) {
                document.querySelectorAll('.sort-icon').forEach(el => el.textContent = "⬍");
                if (icon) {
                    icon.textContent = sortOrder === "desc" ? "⬆" : "⬇";
                }

                let url = type === 'wifi' ? "/api/wifi/data" : "/api/bluetooth/data";
                let tableBody = type === 'wifi' ? "#wifiTableBody" : "#bluetoothTableBody";
                let pageInfo = type === 'wifi' ? "#wifiPageInfo" : "#bluetoothPageInfo";
                let prevBtn = type === 'wifi' ? "#prevWifi" : "#prevBluetooth";
                let nextBtn = type === 'wifi' ? "#nextWifi" : "#nextBluetooth";

                let dateRange = type === 'wifi' ? $('#wifiDateRange').val() : $('#bluetoothDateRange').val();
                let [startDate, endDate] = dateRange ? dateRange.split(' - ') : [null, null];

                if (startDate) startDate = moment(startDate, 'DD MMM YYYY').format('YYYY-MM-DD 00:00:00');
                if (endDate) endDate = moment(endDate, 'DD MMM YYYY').format('YYYY-MM-DD 23:59:59');

                let filters = {
                    device_name: type === 'wifi' ? $('#wifiDeviceName').val() : $('#bluetoothDeviceName').val(),
                    manufacturer: type === 'wifi' ? $('#wifiManufacturer').val() : $('#bluetoothManufacturer')
                        .val(),
                    search_query: type === 'wifi' ? $('#wifiSearch').val() : $('#bluetoothSearch').val(),
                    ssid: type === 'wifi' ? $('#wifiSSID').val() : '',
                    page: page,
                    per_page: perPage,
                    sort_column: sortColumn,
                    sort_order: sortOrder,
                    start_date: startDate,
                    end_date: endDate
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
                            }).join('') :
                            `<tr><td colspan="8" class="text-center h-24 text-gray-500">No data available</td></tr>`;

                        $(tableBody).html(rows);
                        $(pageInfo).text(`Page ${page} of ${response.total_pages}`);
                        $(prevBtn).prop('disabled', page <= 1);
                        $(nextBtn).prop('disabled', page >= response.total_pages);
                    }
                });
            }

            $('.sort-column').click(function() {
                let column = $(this).data('column');
                let order = $(this).data('order') === 'asc' ? 'desc' : 'asc';
                let icon = this.querySelector('.sort-icon');
                $(this).data('order', order);

                let isWiFi = $(this).closest('table').find('#wifiTableBody').length > 0;
                let type = isWiFi ? 'wifi' : 'bluetooth';

                if (!column) {
                    console.error("Invalid column for sorting");
                    return;
                }

                loadTable(type, type === 'wifi' ? wifiPage : bluetoothPage, column, order, icon);
            });


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
        width: 100%;
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
