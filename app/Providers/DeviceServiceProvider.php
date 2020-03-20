<?php

namespace App\Providers;

use App\Models\Device;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DeviceServiceProvider
{
    //si occupa di prendere i device dal database
    private $request;

    public function __construct()
    {
        $this->request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json' ,
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Device
     */
    public function retrieveById($identifier){
        try {
            $response = json_decode($this->request->get('device/'.$identifier, [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $device = new Device();
            $device->fill((array)$response);
            return $device;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function findAll(){
        try {
            $response = json_decode($this->request->get('devices', [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                    ]
                ])->getBody());
            $devices = [];
            foreach ($response as $d){
                $device = new Device();
                $device->fill((array)$d);
                $devices[] = $device;
            }
            return $devices;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
