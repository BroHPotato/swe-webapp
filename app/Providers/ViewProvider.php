<?php

namespace App\Providers;

use App\Models\View;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ViewProvider extends BasicProvider
{
    /**
     * @var Client
     */
    private $request;

    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/views/',
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
            $response = json_decode($this->request->get($identifier, $this->setHeaders())->getBody());
            $view = new View();
            $view->fill((array)$response);
            return $view;
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
            $response = json_decode($this->request->get('', $this->setHeaders())->getBody());
            $views = [];
            foreach ($response as $g) {
                $view = new View();
                $view->fill((array)$g);
                $views[] = $view;
            }
            return $views;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
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
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
