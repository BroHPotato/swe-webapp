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
        $device = $this->deviceProvider->find($device)??[];
        $sensors = $this->sensorProvider->findAllFromDevice($device->deviceId) ?? [];
        $gateways = $this->gatewayProvider->findAll()??[];
        return view('devices.edit', compact(['device', 'sensors','gateways']));
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

    public function store() //todo refactor
    {
        $data = request()->validate([
            'realDeviceId' => 'required|numeric',
            'name' => 'required|string',
            'gatewayId' => 'required|numeric',
            'frequency' => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'sensorId.*' => 'nullable|numeric|required_with:sensorType.*',
            'sensorType.*' => 'nullable|string|required_with:sensorId.*'
        ]);
        if (!$this->deviceProvider->store(json_encode([
            'realDeviceId' => $data['realDeviceId'],
            'name' => $data['name'],
            'gatewayId' => $data['gatewayId'],
            'frequency' => $data['frequency']
        ]))) {
            return redirect(
                route('devices.index')
            )->withErrors(['NotCreate' => 'Dispositivo e Sensori non creati']);
        } elseif ($data['sensorId']) {
            //fetch and filter of the new device
            $devices = $this->deviceProvider->findAllFromGateway($data['gatewayId']);
            $newDevice = current(array_filter($devices, function ($dev) use ($data) {
                return $dev->realDeviceId == $data['realDeviceId'] && $dev->gatewayId == $data['gatewayId'];
            }));
            dd($newDevice);
            /////
            if ($data['sensorId'] === $data['sensorType']) {
                foreach ($data['sensorId'] as $key => $value) {
                    if (!$this->sensorProvider->store($newDevice->deviceId, json_encode([
                        'device' => $newDevice->deviceId,
                        'realSensorId' => $value,
                        'type' => $data['sensorType'][$key]
                    ]))) {
                        return redirect(route('devices.index'))->withErrors(['NotCreate' => 'Dispositivo creato,
                        ma si e verificato un errore durante la creazione dei sensori']);
                    }
                }
            }
            return redirect(route('devices.index'))
                ->withErrors(['GoodCreate' => 'Dispositivo e Sensori creati con successo']);
        } else {
            return
                redirect(route('devices.index'))
                    ->withErrors(['GoodCreate' => 'Dispositivo creato con successo']);
        }
    }

    public function destroy($deviceId)
    {
        return $this->deviceProvider->destroy($deviceId) ?
            redirect(route('devices.index'))
                ->withErrors(['GoodDestroy' => 'Dispositivo eliminato con successo']) :
            redirect(route('devices.index'))
                ->withErrors(['NotDestroy' => 'Dispositivo non eliminato']);
    }

    public function update($deviceId) //todo refactor
    {
        $data = request()->validate([
            'realDeviceId' => 'required|numeric',
            'name' => 'required|string',
            'gatewayId' => 'required|numeric',
            'frequency' => 'required|numeric|in:0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'sensorId.*' => 'nullable|numeric|required_with:sensorType.*',
            'sensorType.*' => 'nullable|string|required_with:sensorId.*'
        ]);
        if (!$this->deviceProvider->update($deviceId, json_encode([
            'realDeviceId' => $data['realDeviceId'],
            'name' => $data['name'],
            'gatewayId' => $data['gatewayId'],
            'frequency' => $data['frequency']
        ]))) {
            return redirect(route('devices.index'))
                ->withErrors(['NotUpdate' => 'Dispositivo e Sensori non aggiornati']);
        } else {
            if ($data['sensorId'] === $data['sensorType']) {
                $data['sensorId'] = $data['sensorId']??[];
                $newDevice = $this->deviceProvider->find($deviceId);
                $oldSensors = $this->sensorProvider->findAllFromDevice($deviceId);

                $oldSensorsId = [];
                foreach ($oldSensors as $s) {
                    $oldSensorsId[] = $s->realSensorId;
                }

                $toInsert = array_diff($data['sensorId'], $oldSensorsId);
                $toDelete = array_diff($oldSensorsId, $data['sensorId']);
                $toModify = array_intersect($data['sensorId'], $oldSensorsId);

                foreach ($toInsert as $key => $value) {
                    if (!$this->sensorProvider->store($newDevice->deviceId, json_encode([
                        'device' => $newDevice->deviceId,
                        'realSensorId' => $value,
                        'type' => $data['sensorType'][$key]
                    ]))) {
                        return redirect(route('devices.index'))
                            ->withErrors(['NotUpdate' => 'Dispositivo aggiornato,
                            ma si e verificato un errore durante l\'aggiornamento dei sensori']);
                    }
                }
                foreach ($toDelete as $key => $value) {
                    if (!$this->sensorProvider->destroy($newDevice->deviceId, $value)) {
                        return redirect(route('devices.index'))
                            ->withErrors(['NotUpdate' => 'Dispositivo aggiornato,
                            ma si e verificato un errore durante l\'aggiornamento dei sensori']);
                    }
                }
                foreach ($toModify as $key => $value) {
                    if (!$this->sensorProvider->update($newDevice->deviceId, $value, json_encode([
                        'realSensorId' => $value,
                        'type' => $data['sensorType'][$key]
                    ]))) {
                        return redirect(route('devices.index'))
                            ->withErrors(['NotUpdate' => 'Dispositivo aggiornato,
                            ma si e verificato un errore durante l\'aggiornamento dei sensori']);
                    }
                }
            }
            return redirect(route('devices.index'))
                ->withErrors(['GoodUpdate' => 'Dispositivo e Sensori aggiornati con successo']);
        }
    }
}
//todo vedere per i comandi
