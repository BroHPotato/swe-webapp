<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Providers\GatewayServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class GatewayController extends Controller
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
        $this->provider = new GatewayServiceProvider();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $gateways = $this->provider->findAll();
        return view('gateways.index', compact('gateways'));
    }

    /**
     * Display the specified resource.
     *
     * @param $gateway
     * @return Factory|View
     */
    public function show($gateway)
    {
        $gateway = $this->provider->find($gateway);
        return view('gateways.show', compact('gateway'));
    }

    /**
     * @return Factory|View
     */
    public function create() //TODO
    {
        $entities = $this->provider->findAll();
        return view('gateways.create', compact(['entities']));
    }

    public function edit($gateway)
    {
        $gateway = $this->provider->find($gateway);
        return view('gateways.edit', compact('gateway'));
    }
}
