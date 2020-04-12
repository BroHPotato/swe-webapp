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
            'base_uri' => config('app.api') . '/devices',
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
                '/devices/' . $deviceId . '/sensors/' . $sensorId,
                $this->setHeaders()
            )->getBody());
            $sensor = new Sensor();
            $sensor->fill((array)$response);
            return $sensor;
        } catch (RequestException $e) {
            $this->isExpired($e);
            return null;
        }
    }

    public function findFromLogicalId($sensorId)
    {
        try {
            $response = json_decode($this->request->get(
                '/sensors/' . $sensorId,
                $this->setHeaders()
            )->getBody());
            $sensor = new Sensor();
            $sensor->fill((array)$response);
            return $sensor;
        } catch (RequestException $e) {
            $this->isExpired($e);
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
            return json_encode(array(
                'time' => date("d/m/Y H:i:s"),
                'value' => rand(0, 10) ,
                'gatewayName' => 'string',
                'realDeviceId' => 0,
                'realSensorId' => 0,
            ));//todo sostituire con
            // json_decode($this->request->get('/data/' . $sensorId, $this->setHeaders())->getBody());
        } catch (RequestException $e) {
            $this->isExpired($e);
            return NAN;
        }
    }
    // ===================================================
    // Mockup per un utente
    // Funzione da rimuovere in production

    /**
     * @return Sensor
     */
    public static function GetASensor()
    {
        $sensor = new Sensor();
        $arr = array_combine(
            array('sensorId', 'type', 'realSensorId', 'device'),
            array("0", "Tipo", "0", '0')
        );
        $sensor->fill($arr);
        return $sensor;
    }
}
