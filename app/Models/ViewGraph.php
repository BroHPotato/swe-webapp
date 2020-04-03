<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewGraph extends Model
{
    protected $fillable = ['viewId', 'correlation', 'sensorId1', 'sensorId2', 'viewGraphId'];
}
