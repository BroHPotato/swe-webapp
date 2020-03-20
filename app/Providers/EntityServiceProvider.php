<?php

namespace App\Providers;

use App\Models\Entity;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EntityServiceProvider
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
     * @return Entity
     */
    public function retrieveById($identifier){
        try {
            $response = json_decode($this->request->get('enity/'.$identifier, [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $entity = new Entity();
            $entity->fill((array)$response);
            return $entity;
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
            $response = json_decode($this->request->get('entities', [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $entities = [];
            foreach ($response as $e){
                $entity = new Entity();
                $entity->fill((array)$e);
                $entities[] = $entity;
            }
            return $entities;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
