<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Providers\DeviceServiceProvider;
use App\Providers\GatewayServiceProvider;
use App\Providers\SensorServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DeviceController extends Controller
{
    private $gatewayProvider;
    private $deviceProvider;
    private $sensorProvider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->gatewayProvider = new GatewayServiceProvider();
        $this->deviceProvider = new DeviceServiceProvider();
        $this->sensorProvider = new SensorServiceProvider();
    }

    public function create()
    {
        $entities = $this->deviceProvider->findAll();
        return view('devices.create', compact('entities'));
    }

    public function edit($device)
    {
        $device = $this->deviceProvider->find($device);
        $sensors = $this->sensorProvider->findAllFromDevice($device->deviceId);

        return view('devices.edit', compact('device', 'sensors'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $gateways = $this->gatewayProvider->findAll();
        $devicesOnGateways = [];
        foreach ($gateways as $g) {
            $sensors = [];
            $devices = $this->deviceProvider->findAll();//todo sostituire con findAllFromGateway($g->gatewayId);
            foreach ($devices as $d) {
                $sensors[$d->deviceId] = count($this->sensorProvider->findAllFromDevice($d->deviceId));
            }
            $devicesOnGateways[$g->gatewayId] = [0 => $g,
                                                1 => $devices,
                                                2 => $sensors
            ];
        }
        return view('devices.index', compact('devicesOnGateways'));
    }

    /**
     * Display the specified resource.
     *
     * @param $device
     * @return Factory|View
     */
    public function show($device)
    {
        $device = $this->deviceProvider->find($device);
        $sensors = $this->sensorProvider->findAllFromDevice($device->deviceId);
        $gateway = $this->gatewayProvider->findAllFromDevice($device->deviceId)[0];
        return view('devices.show', compact(['device', 'sensors', 'gateway']));
    }
}
