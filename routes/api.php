<?php

use App\Http\Controllers\BluetoothController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\WifiController;
use App\Http\Controllers\DeviceLogController;

// Devices
Route::post('devices', [DevicesController::class, 'create']);

// Bluetooth
Route::post('bluetooth', [BluetoothController::class, 'create']);
Route::get('/bluetooth/data', [BluetoothController::class, 'getBluetoothData'])->name('bluetooth.data');
Route::get('/bluetooth/filters', [BluetoothController::class, 'getBluetoothFilters'])->name('bluetooth.filters');

// WiFi
Route::post('wifi', [WifiController::class, 'create']);
Route::get('/wifi/data', [WifiController::class, 'getWiFiData'])->name('wifi.data');
Route::get('/wifi/filters', [WifiController::class, 'getWifiFilters'])->name('wifi.filters');

// Device Log
Route::post('/logs', [DeviceLogController::class, 'store']);