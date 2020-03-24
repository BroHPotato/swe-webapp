<?php

namespace App\Providers;

use App\Models\Entity;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\ServiceProvider;

class EntityServiceProvider extends ServiceProvider
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
     * @return Entity
     */
    public function retrieveById($identifier)
    {
        try {
            $response = json_decode($this->request->get('entity/' . $identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $entity = new Entity();
            $entity->fill((array)$response);
            return $entity;
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
            $response = json_decode($this->request->get('entities', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $entities = [];
            foreach ($response as $e) {
                $entity = new Entity();
                $entity->fill((array)$e);
                $entities[] = $entity;
            }
            return $entities;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    public function findFromDevice($deviceId)
    {
        try {
            $response = json_decode($this->request->get('entities', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ],
                'query' => 'deviceId=' . $deviceId
            ])->getBody());
            $entity = new Entity();
            $entity->fill((array)$response);
            return $entity;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    public function findFromUser($userId)
    {
        try {
            $response = json_decode($this->request->get('entities', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ],
                'query' => 'userId=' . $userId
            ])->getBody());
            $entity = new Entity();
            $entity->fill((array)$response);
            return $entity;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
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
}
