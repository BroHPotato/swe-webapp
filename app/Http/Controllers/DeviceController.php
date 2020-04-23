<?php

namespace App\Http\Controllers;

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
        $gateways = $this->gatewayProvider->findAll();
        return view('devices.create', compact('gateways'));
    }

    public function edit($device)
    {
        $device = $this->deviceProvider->find($device);
        $sensors = $this->sensorProvider->findAllFromDevice($device->deviceId) ?? [];
        return view('devices.edit', compact(['device', 'sensors']));
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
            $devices = $this->deviceProvider->findAllFromGateway($g->gatewayId);
            foreach ($devices as $d) {
                $sensors[$d->deviceId] = count($this->sensorProvider->findAllFromDevice($d->deviceId) ?? []);
            }
            $devicesOnGateways[$g->gatewayId] = ['gateway' => $g,
                                                'devices' => $devices,
                                                'sensors' => $sensors
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
    public function show($deviceId)
    {
        $device = $this->deviceProvider->find($deviceId) ?? [];
        $sensors = $this->sensorProvider->findAllFromDevice($device->deviceId) ?? [];
        $gateway = $this->gatewayProvider->findAllFromDevice($device->deviceId)[0] ?? [];
        return view('devices.show', compact(['device', 'sensors', 'gateway']));
    }

    public function store()
    {
        dd(request()->all());
        $data = request()->validate([
            'realDeviceId' => 'required|numeric',
            'name' => 'required|string',
            'gatewayId' => 'required|numeric',
            'frequency' => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5'
        ]);
        return $this->gatewayProvider->store(json_encode($data)) ?
            redirect(route('gateways.index'))->withErrors(['GoodCreate' => 'Gateway creato con successo']) :
            redirect(route('gateways.index'))->withErrors(['NotCreate' => 'Gateway non creato']);
    }
}
