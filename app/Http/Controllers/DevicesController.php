<?php

namespace App\Http\Controllers;

use App\Device;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DevicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function index( $user)
    {
        return view('devices.index', compact('user', 'devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //API to store
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param Device $device
     * @return Factory|View
     */
    public function show($user, $device)
    {
        return view('devices.show', compact('user', 'device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        //API to update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy()
    {
        //API to destroy
    }
}
