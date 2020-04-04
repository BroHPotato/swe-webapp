<?php

namespace App\Providers;

use App\Models\ViewGraph;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ViewGraphProvider extends BasicProvider
{
    /**
     * @var Client
     */
    private $request;

    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/viewsGraphs/',
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return ViewGraph
     */
    public function find($identifier)
    {
        try {
            $response = json_decode($this->request->get($identifier, $this->setHeaders())->getBody());
            $graph = new ViewGraph();
            $graph->fill((array)$response);
            return $graph;
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
            $graph = [];
            foreach ($response as $g) {
                $graph = new ViewGraph();
                $graph->fill((array)$g);
                $graph[] = $graph;
            }
            return $graph;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
    public function findAllFromView($viewId)
    {
        try {
            $response = json_decode($this->request->get('', array_merge($this->setHeaders(), [
                'query' => 'viewId=' . $viewId
            ]))->getBody());
            $graphs = [];
            foreach ($response as $g) {
                $graph = new ViewGraph();
                $graph->fill((array)$g);
                $graphs[] = $graph;
            }
            return $graphs;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
}
