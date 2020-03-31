<?php

namespace App\Providers;

use App\Models\Gateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\ServiceProvider;
use function config;

/**
 * Class GatewayServiceProvider
 * @package App\Providers
 */
class GatewayServiceProvider extends ServiceProvider
{
    //si occupa di prendere i device dal database
    /**
     * @var Client
     */
    private $request;

    /**
     * GatewayServiceProvider constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/gateways',
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Gateway
     */
    public function retrieveById($identifier)
    {
        try {
            $response = json_decode($this->request->get($identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $gateway = new Gateway();
            $gateway->fill((array)$response);
            return $gateway;
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
            $response = json_decode($this->request->get('', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $gateways = [];
            foreach ($response as $g) {
                $gateway = new Gateway();
                $gateway->fill((array)$g);
                $gateways[] = $gateway;
            }
            return $gateways;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
