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

// WiFi
Route::post('wifi', [WifiController::class, 'create']);

// Device Log
Route::post('/logs', [DeviceLogController::class, 'store']);