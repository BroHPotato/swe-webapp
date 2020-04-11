<?php

namespace App\Providers;

use App\Models\View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ViewServiceProvider extends BasicProvider
{
    /**
     * @var Client
     */
    private $request;

    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/views',
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return View
     */
    public function find($identifier)
    {
        try {
            $response = json_decode($this->request->get('/views/' . $identifier, $this->setHeaders())->getBody());
            $view = new View();
            $view->fill((array)$response);
            return $view;
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
            $response = json_decode($this->request->get('', $this->setHeaders())->getBody());
            $views = [];
            foreach ($response as $g) {
                $view = new View();
                $view->fill((array)$g);
                $views[] = $view;
            }
            return $views;
        } catch (RequestException $e) {
            $this->isExpired($e);
            return null;
        }
    }

    public function findAllFromUser($user)
    {
        try {
            $response = json_decode($this->request->get('', array_merge($this->setHeaders(), [
                'query' => 'userId=' . $user
            ]))->getBody());
            $views = [];
            foreach ($response as $g) {
                $view = new View();
                $view->fill((array)$g);
                $views[] = $view;
            }
            return $views;
        } catch (RequestException $e) {
            $this->isExpired($e);
            return null;
        }
    }
    /**
     * @param string $who
     */
    public function destroy(string $who)
    {
        try {
            $this->request->delete('/views/' . $who, $this->setHeaders());
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    /**
     * @param string $body
     */
    public function store(string $body)
    {
        try {
            $this->request->post('', array_merge($this->setHeaders(), [
                'body' => $body
            ]));
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }
}