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
            'base_uri' => 'core.host.redroundrobin.site:9999',
            'headers' => [
                'Content-Type' => 'application/json' ,
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Sensor
     */
    public function find($deviceId ,$sensorId)
    {
        try {
            $response = json_decode($this->request->get('device/' . $deviceId . '/sensor/' . $sensorId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ],
            ])->getBody());
            $sensor = new Sensor();
            $sensor->fill((array)$response);
            return $sensor;
        } catch (RequestException $e) {
            $this->isExpired($e);
            //abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            $s = new Sensor();
            $s->fill(array_combine(['sensorId', 'type', 'deviceSensorId', 'deviceId'], [1,'boh', 1, 1]));
            return $s;//null;
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
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    public function findAllFromDevice($deviceId)
    {
        try {
            $response = json_decode($this->request->get('device/' . $deviceId . '/sensors', [
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
            $this->isExpired($e);
            //abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            $s1 = new Sensor();
            $s2 = new Sensor();
            $s1->fill(array_combine(['sensorId', 'type', 'deviceSensorId', 'deviceId'], [1,'boh', 1, 1]));
            $s2->fill(array_combine(['sensorId', 'type', 'deviceSensorId', 'deviceId'], [2,'buh', 2, 1]));
            return [$s1, $s2];//null;
        }
    }

    private function isExpired(RequestException $e)
    {
        if ($e->getCode() == 419/*fai il controllo del token*/) {
            session()->invalidate();
            session()->flush();
            return redirect('login');
        }
    }

    public function fetch($device ,$sensorId)
    {
        try {
            return json_decode($this->request->get('sensor', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
        } catch (RequestException $e) {
            $this->isExpired($e);
            return NAN;
        }
    }
}
