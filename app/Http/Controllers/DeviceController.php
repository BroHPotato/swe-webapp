<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Providers\DeviceServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DeviceController extends Controller
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
        $this->provider = new DeviceServiceProvider();
    }

    public function create()
    {
        $entities = $this->provider->findAll();
        return view('devices.create', compact(['entities']));
    }

    public function edit($device)
    {
        //$device = $this->provider->find($device);
        ///FAKER
        $device = new Device();
        $arr = array_combine(
            array('deviceId', 'name', 'gateway','frequency', 'status'),
            array("1", "dev1", "US-Gateway", 1, "attivo")
        );
        $device->fill($arr);
        $devices[] = $device;
        //TODO remove
        return view('devices.edit', compact('device'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        //$devices = $this->provider->findAll();
        ///FAKER
        $user = new Device();
        $arr = array_combine(
            array('deviceId', 'name', 'frequency', 'gatewayId'),
            array("1", "dev1", 123, 1)
        );
        $user->fill($arr);
        $devices[] = $user;
        //TODO remove
        return view('devices.index', compact('devices'));
    }

    /**
     * Display the specified resource.
     *
     * @param $device
     * @return Factory|View
     */
    public function show($device)
    {
        //$device = $this->provider->find($device);
        ///FAKER
        $user = new Device();
        $arr = array_combine(
            array('deviceId', 'name', 'frequency', 'gatewayId'),
            array("1", "dev1", 123, 1)
        );
        $user->fill($arr);
        $device = $user;
        //TODO remove
        return view('devices.show', compact('device'));
    }
}
