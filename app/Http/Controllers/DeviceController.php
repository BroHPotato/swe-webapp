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

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $devices = $this->provider->findAll();
                            $user = new Device();
                            $arr = array_combine(
                                array('deviceId', 'name', 'frequency', 'gatewayId'),
                                array("1", "dev1", 123, 1)
                            );
                            $user->fill($arr);
                            $devices[] = $user;
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
        $device = $this->provider->retrieveById($device);
        return view('devices.show', compact('device'));
    }
}
