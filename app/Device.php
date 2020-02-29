<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['deviceId', 'timestamp', 'sensorsList', 'sensorsNumber'];

}
