<?php

namespace App\Models;

use App\Providers\EntityServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['deviceId', 'name', 'frequency', 'realDeviceId'];
}
