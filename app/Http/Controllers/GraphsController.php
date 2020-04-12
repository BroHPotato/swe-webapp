<?php

namespace App\Http\Controllers;

use App\Providers\ViewGraphServiceProvider;
use App\Providers\ViewServiceProvider;

class GraphsController extends Controller
{
    private $viewGraphProvider;
    private $viewProvider;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->viewGraphProvider = new ViewGraphServiceProvider();
        $this->viewProvider = new ViewServiceProvider();
    }
    public function store($viewId)
    {
        if ($this->viewProvider->find($viewId)) {
            $data = request()->validate([
                'correlation' => 'required|string|in:0,1,2,3',
                'sensor1' => 'required|string|different:sensor2',
                'sensor2' => 'required|string|different:sensor1'
            ]);
            $data['view'] = $viewId;
            $data = array_map(function ($value) {
                return (int)$value;
            }, $data);
            $this->viewGraphProvider->store(json_encode($data));
            return redirect(route('views.show', ['viewId' => $viewId]))->withErrors(['GoodCreate' => 'Grafico creato con successo']);
        }
        return redirect(route('views.show', ['viewId' => $viewId]))->withErrors(['NotCreate' => 'Grafico non creato']);
    }
    public function destroy($viewGraphId)
    {
        $viewgraph = $this->viewGraphProvider->find($viewGraphId);
        return $this->viewGraphProvider->destroy($viewGraphId) ?
            redirect(route('views.show', ['viewId' => $viewgraph->view]))->withErrors(['GoodDestroy' => 'Grafico eliminato con successo']) :
            redirect(route('views.show', ['viewId' => $viewgraph->view]))->withErrors(['NotDestroy' => 'Eliminazione non avvenuta']);
    }
}
