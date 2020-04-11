<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\DeviceServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

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
        $sensorsCache = [];
        foreach ($alerts as $state => $alertsList) {
            foreach ($alertsList as $alert) {
                key_exists($alert->sensor, $sensorsCache) ? $sensor = $sensorsCache[$alert->sensor] : $sensor = $this->sensorsProvider->findFromLogicalId($alert->sensor);
                $alertsWithSensors[$state][] = [
                    'alert' => $alert,
                    'sensor' => $sensor,
                    'device' => $this->devicesProvider->find($sensor->device)
                ];
            }
        }
        return view('alerts.index', compact('alertsWithSensors'));
    }
    public function create()
    {
        return view('alerts.create', compact(''));
    }

    /**
     * @param $alert
     * @return Factory|View
     */
    public function edit($alert)
    {
        return view('alerts.edit', compact('alert'));
    }

    /**
     *
     */
    public function store()
    {
        $data = request()->validate([
        ]);
        $this->alertsProvider->store(json_encode($data));
        return redirect(route('alerts.index'));
    }

    /**
     * @param $alertId
     * @return RedirectResponse|Redirector
     */
    public function update($alertId)
    {
        $data = request()->validate([
        ]);
        $this->alertsProvider->update($alertId, json_encode($data, JSON_FORCE_OBJECT));
        return redirect(route('alerts.index'));
    }

    /**
     * @param $alertId
     * @return RedirectResponse|Redirector
     */
    public function destroy($alertId)
    {
        $this->alertsProvider->destroy($alertId);
        return redirect(route('alerts.index'));
    }
}
