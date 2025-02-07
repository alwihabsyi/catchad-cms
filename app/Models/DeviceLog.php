<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceLog extends Model
{
    use HasFactory;

    protected $table = 'devicelog';

    protected $fillable = [
        'log_message',
        'device_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
