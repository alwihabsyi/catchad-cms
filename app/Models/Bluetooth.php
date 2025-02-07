<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bluetooth extends Model
{
    use HasFactory;

    protected $table = 'bluetooth';
    protected $primaryKey = 'address';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'address',
        'name',
        'manufacturer',
        'rssi',
        'device_id'
    ];
    
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
