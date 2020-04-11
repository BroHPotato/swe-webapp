<?php

namespace App\Providers;

use App\Models\Gateway;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LogsServiceProvider extends BasicProvider
{
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
            'base_uri' => config('app.api') . '/logs',
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @return array|null
     */
    public function findAll()
    {
        try {
            $response = json_decode($this->request->get('', $this->setHeaders())->getBody());
            return $response;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}