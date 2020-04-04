<?php

namespace App\Providers;

use App\Models\Entity;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use function config;

/**
 * Class EntityServiceProvider
 * @package App\Providers
 */
class EntityServiceProvider extends BasicProvider
{
    //si occupa di prendere i device dal database
    /**
     * @var Client
     */
    private $request;

    /**
     * EntityServiceProvider constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/entities/',
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Entity
     */
    public function find($identifier)
    {
        try {
            $response = json_decode($this->request->get($identifier, $this->setHeaders())->getBody());
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
            $response = json_decode($this->request->get('', $this->setHeaders())->getBody());
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

    /**
     * @param $deviceId
     * @return Entity|null
     */
    public function findFromDevice($deviceId)
    {
        try {
            $response = json_decode($this->request->get('entities', array_merge($this->setHeaders(), [
                'query' => 'deviceId=' . $deviceId
            ]))->getBody());
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
     * @param $userId
     * @return Entity|null
     */
    public function findFromUser($userId)
    {
        try {
            $response = json_decode($this->request->get('entities', array_merge($this->setHeaders(), [
                'query' => 'userId=' . $userId
            ]))->getBody());
            $entity = new Entity();
            $entity->fill((array)$response);
            return $entity;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
