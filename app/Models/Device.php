<?php

namespace App\Models;

use App\Providers\EntityServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['deviceId', 'name', 'frequency', 'gatewayId'];

    public function getSensors()
    {
        $provider = new SensorServiceProvider();
        return $provider->findAllFromDevice($this->deviceId);
    }

    public function getEntity()
    {
        $provider = new EntityServiceProvider();
        return $provider->retrieveByDevice($this->deviceId);
    }
}
