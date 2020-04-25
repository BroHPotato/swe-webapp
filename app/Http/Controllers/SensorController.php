<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\DeviceServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class SensorController extends Controller
{
    private $sensorProvider;
    private $deviceProvider;
    private $alertProvider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->sensorProvider = new SensorServiceProvider();
        $this->deviceProvider = new DeviceServiceProvider();
        $this->alertProvider = new AlertServiceProvider();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index($device)
    {
        $sensors = $this->sensorProvider->findAllFromDevice($device);
        return view('sensors.index', compact(['sensors', 'device']));
    }

    /**
     * Display the specified resource.
     *
     * @param $sensor
     * @return Factory|View
     */
    public function show($deviceId, $sensorId)
    {
        $sensor = $this->sensorProvider->find($deviceId, $sensorId) ?? abort(404);
        $device = $this->deviceProvider->find($deviceId) ?? abort(404);
        $alerts = $this->alertProvider->findAllFromSensor($sensor->sensorId);
        return view('sensors.show', compact(['sensor', 'device', 'alerts']));
    }

    public function fetch($sensorId)
    {
        return $this->sensorProvider->fetch($sensorId);
    }

    public function fetchMoar()
    {
        return $this->sensorProvider->fetchMoar();
    }
}
