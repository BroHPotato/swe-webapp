<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\DeviceServiceProvider;
use App\Providers\SensorServiceProvider;

class AlertsController extends Controller
{
    private $alertsProvider;
    private $devicesProvider;
    private $sensorsProvider;


    public function __construct()
    {
        $this->middleware('auth');
        $this->alertsProvider = new AlertServiceProvider();
        $this->devicesProvider = new DeviceServiceProvider();
        $this->sensorsProvider = new SensorServiceProvider();
    }

    public function index()
    {
        $alerts = $this->alertsProvider->findAll();
        $alertsWithSensors = [];
        foreach ($alerts as $state => $alertsList) {
            foreach ($alertsList as $alert) {
                $sensor = $this->sensorsProvider->findFromLogicalId($alert->sensor);
                $alertsWithSensors[$state][] = [
                    'alert' => $alert,
                    'sensor' => $sensor,
                    'device' => $this->devicesProvider->find($sensor->device)
                ];
            }
        }
        return view('alerts.index', compact('alertsWithSensors'));
    }
}
