<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Support\Collection
     */
    public function index($user)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://core.host.redroundrobin.site/devices');
        $response = json_decode($res->getBody(), true);

        $devices = collect();
        foreach ($response["devicesList"] as $tempdevice) {
            $dev = new Device();
            $dev->fill($tempdevice);
            $devices->push($dev);
        }
        return $devices;
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
        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://core.host.redroundrobin.site/device/'.$device);
        $response = json_decode($res->getBody(),true);

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
