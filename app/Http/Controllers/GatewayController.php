<?php

namespace App\Http\Controllers;

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
        $gateway = $this->provider->retrieveById($gateway);
        return view('gateways.show', compact('gateway'));
    }
}
