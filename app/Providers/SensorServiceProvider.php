<?php

namespace App\Providers;

use App\Models\Sensor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\ServiceProvider;

class SensorServiceProvider extends ServiceProvider
{
    //si occupa di prendere i device dal database
    private $request;

    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json' ,
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Sensor
     */
    public function retrieveById($identifier)
    {
        try {
            $response = json_decode($this->request->get('sensor/' . $identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $sensor = new Sensor();
            $sensor->fill((array)$response);
            return $sensor;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function findAll()
    {
        try {
            $response = json_decode($this->request->get('sensors', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $sensors = [];
            foreach ($response as $d) {
                $sensor = new Sensor();
                $sensor->fill((array)$d);
                $sensors[] = $sensor;
            }
            return $sensors;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
