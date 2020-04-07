<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\ViewGraph;
use App\Providers\SensorServiceProvider;
use App\Providers\ViewGraphServiceProvider;
use App\Providers\ViewServiceProvider;

class ViewController extends Controller
{
    private $viewProvider;
    private $viewGraphProvider;
    private $sensorProvider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->viewProvider = new ViewServiceProvider();
        $this->viewGraphProvider = new ViewGraphServiceProvider();
        $this->sensorProvider = new SensorServiceProvider();
    }

    public function index()
    {
        $views = $this->viewProvider->findAll();
        return view('views.index', compact('views'));
    }

    public function show($viewId)
    {
        $graphs = $this->viewGraphProvider->findAllFromView($viewId);
        $view = $this->viewProvider->find($viewId);
        $sensor1 = $this->sensorProvider->find(1,1);
        $sensor2 = $this->sensorProvider->find(1,2);
        return view('views.show', compact(['graphs','view', 'sensor1', 'sensor2']));
    }
}
