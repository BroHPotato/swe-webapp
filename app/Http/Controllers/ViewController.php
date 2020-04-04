<?php

namespace App\Http\Controllers;

use App\Providers\ViewGraphProvider;
use App\Providers\ViewProvider;
use Illuminate\Support\Facades\Auth;

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
        $this->viewProvider = new ViewProvider();
        $this->viewGraphProvider = new ViewGraphProvider();
    }

    public function index()
    {
        $views = $this->viewProvider->findAll();
        return view('views.index', compact('views'));
    }

    public function show($viewId)
    {
        $graphs = $this->viewGraphProvider->findAllFromView($viewId);
        return view('views.show', compact('graphs'));
    }
}
