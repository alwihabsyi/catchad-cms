<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wifi extends Model
{
    use HasFactory;
    protected $table = 'wifi';
    protected $primaryKey = 'bssid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'bssid',
        'ssid',
        'frequency',
        'rssi',
        'device_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
