<?php

namespace App\Providers;

use App\Models\Sensor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

/**
 * Class SensorServiceProvider
 * @package App\Providers
 */
class SensorServiceProvider extends ServiceProvider
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
            $response = json_decode($this->request->get($deviceId . '/sensor/' . $sensorId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ],
            ])->getBody());
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
     * @param RequestException $e
     * @return RedirectResponse|Redirector
     */
    private function isExpired(RequestException $e)
    {
        if ($e->getCode() == 419/*fai il controllo del token*/) {
            session()->invalidate();
            session()->flush();
            return redirect('login');
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
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
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

    /**
     * @param $deviceId
     * @return array
     */
    public function findAllFromDevice($deviceId)
    {
        try {
            $response = json_decode($this->request->get($deviceId . '/sensors', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
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

    /**
     * @param $device
     * @param $sensorId
     * @return mixed
     */
    public function fetch($device, $sensorId)
    {
        try {
            return json_decode($this->request->get('sensor', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ])->getBody());
        } catch (RequestException $e) {
            $this->isExpired($e);
            return NAN;
        }
    }
}
