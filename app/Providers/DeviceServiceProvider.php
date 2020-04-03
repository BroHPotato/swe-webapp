<?php

namespace App\Providers;

use App\Models\Device;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

use function config;

/**
 * Class DeviceServiceProvider
 * @package App\Providers
 */
class DeviceServiceProvider extends ServiceProvider
{
    //si occupa di prendere i device dal database
    /**
     * @var Client
     */
    private $request;

    /**
     * DeviceServiceProvider constructor.
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
     * @return Device
     */
    public function find($identifier)
    {
        try {
            $response = json_decode($this->request->get($identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ])->getBody());
            $device = new Device();
            $device->fill((array)$response);
            return $device;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    /**
     * @return array|null
     */
    public function findAll()
    {
        try {
            $response = json_decode($this->request->get('', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ])->getBody());
            $devices = [];
            foreach ($response as $d) {
                $device = new Device();
                $device->fill((array)$d);
                $devices[] = $device;
            }
            return $devices;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
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
     * @param $entity
     * @return array
     */
    public function findAllFromEntity($entity)
    {
        try {
            $response = json_decode($this->request->get('', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ],
                'query' => 'entityId=' . $entity
            ])->getBody());
            $devices = [];
            foreach ($response as $d) {
                $device = new Device();
                $device->fill((array)$d);
                $devices[] = $device;
            }
            return $devices;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }
}
