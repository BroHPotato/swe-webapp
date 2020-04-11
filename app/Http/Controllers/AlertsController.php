<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\DeviceServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlertsController extends Controller
{
    private $alertProvider;
    private $deviceProvider;
    private $sensorProvider;

    public function __construct()
    {
        $this->middleware('auth');
        $this->alertProvider = new AlertServiceProvider();
        $this->deviceProvider = new DeviceServiceProvider();
        $this->sensorProvider = new SensorServiceProvider();
    }

    public function index()
    {
        $alerts = $this->alertProvider->findAll();
        $alertsWithSensors = [];
        $sensorsCache = [];
        foreach ($alerts as $state => $alertsList) {
            foreach ($alertsList as $alert) {
                key_exists($alert->sensor, $sensorsCache) ? $sensor = $sensorsCache[$alert->sensor] : $sensor = $this->sensorProvider->findFromLogicalId($alert->sensor);
                $alertsWithSensors[$state][] = [
                    'alert' => $alert,
                    'sensor' => $sensor,
                    'device' => $this->deviceProvider->find($sensor->device)
                ];
            }
        }
        return view('alerts.index', compact('alertsWithSensors'));
    }
    public function create()
    {
        $devices = $this->deviceProvider->findAll();
        foreach ($devices as $d) {
            $sensors[$d->deviceId] = $this->sensorProvider->findAllFromDevice($d->deviceId);
        }
        return view('alerts.create', compact(['devices', 'sensors']));
    }

    /**
     * @param $alertId
     * @return Factory|View
     */
    public function edit($alertId)
    {
        $alert = $this->alertProvider->find($alertId);
        $devices = $this->deviceProvider->findAll();
        foreach ($devices as $d) {
            $sensors[$d->deviceId] = $this->sensorProvider->findAllFromDevice($d->deviceId);
        }
        return view('alerts.edit', compact(['alert', 'devices', 'sensors']));
    }

    /**
     *
     */
    public function store()
    {
        $data = request()->validate([
            "sensor" => 'required|numeric',
            "threshold" => 'required|numeric',
            "type" => 'required|in:0,1,2'
        ]);
        $data["sensor"] = intval($data["sensor"]);
        $data["threshold"] = doubleval($data["threshold"]);
        $data["type"] = intval($data["type"]);
        $data["entity"] = Auth::user()->entity;
        $this->alertProvider->store(json_encode($data));
        return redirect(route('alerts.index'));
    }

    /**
     * @param $alertId
     * @return RedirectResponse|Redirector
     */
    public function update($alertId)
    {
        $data = request()->validate([
            "sensor" => 'required|numeric',
            "threshold" => 'required|numeric',
            "type" => 'required|in:0,1,2'
        ]);
        $data["sensor"] = intval($data["sensor"]);
        $data["threshold"] = doubleval($data["threshold"]);
        $data["type"] = intval($data["type"]);
        $this->alertProvider->update($alertId, json_encode($data, JSON_FORCE_OBJECT));
        return redirect(route('alerts.index'));
    }

    /**
     * @param $alertId
     * @return RedirectResponse|Redirector
     */
    public function destroy($alertId)
    {
        $this->alertProvider->destroy($alertId);
        return redirect(route('alerts.index'));
    }
}
