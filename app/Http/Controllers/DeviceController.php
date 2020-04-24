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
        $data = request()->validate([
            'realDeviceId' => 'required|numeric',
            'name' => 'required|string',
            'gatewayId' => 'required|numeric',
            'frequency' => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'sensorId.*' => 'nullable|numeric|required_with:sensorType.*',
            'sensorType.*' => 'nullable|string|required_with:sensorId.*'
        ]);
        $createdDevice = $this->deviceProvider->store(json_encode([
            'realDeviceId' => $data['realDeviceId'],
            'name' => $data['name'],
            'gatewayId' => $data['gatewayId'],
            'frequency' => $data['frequency']
        ]));
        if (!$createdDevice) {
            return redirect(route('devices.index'))->withErrors(['NotCreate' => 'Dispositivo e Sensori non creati']);
        } elseif ($data['sensorId']) {
            $createdSensor = false;
            if ($data['sensorId'] === $data['sensorType']) {
                foreach ($data['sensorId'] as $key => $value) {
                    $createdSensor = $this->sensorProvider->store(json_encode([
                        'realDeviceId' => $data['realDeviceId'],
                        'realSensorId' => $value,
                        'type' => $data['sensorType'][$key]
                    ]));
                    if (!$createdSensor) {
                        break;
                    }
                }
            }
            if (!$createdSensor) {
                return redirect(route('devices.index'))->withErrors(['NotCreate' => 'Dispositivo creato e Sensori non creati']);
            } else {
                return redirect(route('devices.index'))->withErrors(['GoodCreate' => 'Dispositivo e Sensori creati con succerro']);
            }
        } else {
            return
                redirect(route('devices.index'))->withErrors(['GoodCreate' => 'Dispositivo creato con successo']);
        }
    }

    public function destroy($deviceId)
    {
        return $this->deviceProvider->destroy($deviceId) ?
            redirect(route('devices.index'))->withErrors(['GoodDestroy' => 'Dispositivo eliminato con successo']) :
            redirect(route('devices.index'))->withErrors(['NotDestroy' => 'Dispositivo non eliminato']);
    }
}
