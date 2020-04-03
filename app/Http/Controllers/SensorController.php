<?php

namespace App\Http\Controllers;

use App\Providers\SensorServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class SensorController extends Controller
{
    private $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->provider = new SensorServiceProvider();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index($device)
    {
        $sensors = $this->provider->findAllFromDevice($device);
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
        $sensor = $this->provider->find($deviceId, $sensorId);
        return view('sensors.show', compact(['sensor', 'deviceId']));
    }

    public function fetch($device, $sensor)
    {
        return $this->provider->fetch($device, $sensor);
    }
}
