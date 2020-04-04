<?php

namespace App\Providers;

use App\Models\Sensor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SensorServiceProvider
 * @package App\Providers
 */
class SensorServiceProvider extends BasicProvider
{
    //si occupa di prendere i device dal database
    /**
     * @var Client
     */
    private $request;

    /**
     * SensorServiceProvider constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/devices/',
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Sensor
     */
    public function find($deviceId, $sensorId)
    {
        try {
            $response = json_decode($this->request->get(
                '/devices/' . $deviceId . '/sensor/' . $sensorId,
                $this->setHeaders()
            )->getBody());
            $sensor = new Sensor();
            $sensor->fill((array)$response);
            return $sensor;
        } catch (RequestException $e) {
            $this->isExpired($e);
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
            $response = json_decode($this->request->get('/sensors', $this->setHeaders())->getBody());
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

    /**
     * @param $deviceId
     * @return array
     */
    public function findAllFromDevice($deviceId)
    {
        try {
            $response = json_decode($this->request->get(
                '/devices/' . $deviceId . '/sensors',
                $this->setHeaders()
            )->getBody());
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

    /**
     * @param $sensorId
     * @return mixed
     */
    public function fetch($sensorId)
    {
        try {
            return '{
  "time": "2020-04-04T09:43:06.316Z",
  "gatewayName": "string",
  "realDeviceId": 0,
  "realSensorId": 0,
  "value": ' . rand(0, 10) . '
}';//todo sostituire con json_decode($this->request->get('/data/' . $sensorId, $this->setHeaders())->getBody());
        } catch (RequestException $e) {
            $this->isExpired($e);
            return NAN;
        }
    }
}
