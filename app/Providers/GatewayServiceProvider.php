<?php

namespace App\Providers;

use App\Models\Gateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GatewayServiceProvider
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
     * @return Gateway
     */
    public function retrieveById($identifier){
        try {
            $response = json_decode($this->request->get('gateways/'.$identifier, [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $gateway = new Gateway();
            $gateway->fill((array)$response);
            return $gateway;
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
            $response = json_decode($this->request->get('gateways', [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $gateways = [];
            foreach ($response as $g){
                $gateway = new Gateway();
                $gateway->fill((array)$g);
                $gateways[] = $gateway;
            }
            return $gateways;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}

