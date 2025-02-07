<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\BluetoothController;
use App\Http\Controllers\WifiController;
use App\Http\Controllers\DeviceLogController;

Route::get('/', [DevicesController::class, 'index']);
Route::get('/device/{id}', [DevicesController::class, 'show'])->name('device.show');

Route::post('/delete-devices', [DevicesController::class, 'deleteAll']);
Route::post('/delete-bluetooth', [BluetoothController::class, 'deleteAll']);
Route::post('/delete-wifi', [WifiController::class, 'deleteAll']);

Route::get('/logs/{device_id}', [DeviceLogController::class, 'index'])->name('logs.show');