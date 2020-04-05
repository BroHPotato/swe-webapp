<?php

namespace App\Http\Controllers;

use App\Models\View;
use App\Models\ViewGraph;
use App\Providers\ViewGraphServiceProvider;
use App\Providers\ViewServiceProvider;

class ViewController extends Controller
{
    private $viewProvider;
    private $viewGraphProvider;

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
    }

    public function index()
    {
        //$views = $this->viewProvider->findAll();
        //FAKER
        $view = new View();
        $arr1 = array_combine(
            array('name', 'userId', 'viewId', 'viewGraphId'),
            array("Vista1", "1", "1","1")
        );
        $view->fill($arr1);
        $views[] = $view;
        //todo remove
        return view('views.index', compact('views'));
    }

    public function show($viewId)
    {
        //$graphs = $this->viewGraphProvider->findAllFromView($viewId);
        //FAKER
        $view = new View();
        $arr1 = array_combine(
            array('name', 'userId', 'viewId', 'viewGraphId'),
            array("Vista1", "1", "1","1")
        );
        $view->fill($arr1);
        $viewgraph = new ViewGraph();
        $arr = array_combine(
            array('viewId', 'correlation', 'sensorId1', 'sensorId2', 'viewGraphId'),
            array("1", "0", "1","1","1")
        );
        $viewgraph->fill($arr);
        $graphs[] = $viewgraph;
        //TODO remove
        return view('views.show', compact(['graphs','view']));
    }
}
