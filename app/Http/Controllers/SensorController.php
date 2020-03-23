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
    public function index()
    {
        $sensors = $this->provider->findAll();
        return view('sensors.index', compact('sensors'));
    }

    /**
     * Display the specified resource.
     *
     * @param $sensor
     * @return Factory|View
     */
    public function show($sensor)
    {
        $sensor = $this->provider->retrieveById($sensor);
        return view('sensors.show', compact('sensor'));
    }
}
