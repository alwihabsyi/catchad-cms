<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'brand',
        'manufacturer',
    ];
}