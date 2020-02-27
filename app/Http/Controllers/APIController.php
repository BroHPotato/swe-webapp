<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $user
     * @param $device
     * @return \Illuminate\Http\Response|string
     */
    public function show($user, $device)
    {
        $response = array(
            'nome' => 'device_1',
            'sensori' => array(
                array(
                    'nome' => 'temp_air',
                    'dato' => rand(0,10)
                ),
                array(
                    'nome' => 'temp_oil',
                    'dato' => rand(0,10)
                ),
                array(
                    'nome' => 'utilz',
                    'dato' => rand(0,10)
                )
            ),
        );//todo API Request here for data of device

        $device = new Device();
        $device->fill($response);
        return json_encode($device->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
