<?php

namespace App\Providers;

use App\Models\Alert;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class AlertServiceProvider extends BasicProvider
{
    private $request;

    /**
     * EntityServiceProvider constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api') . '/alerts',
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return Alert
     */
    public function find($identifier)
    {
        try {
            $response = json_decode($this->request->get('/alerts/' . $identifier, $this->setHeaders())->getBody());
            $alert = new Alert();
            $alert->fill((array)$response);
            return $alert;
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
            $alerts = ['enable' => [], 'disable' => []];
            foreach ($response->enabled as $e) {
                $alert = new Alert();
                $alert->fill((array)$e);
                $alerts['enable'][] = $alert;
            }
            foreach ($response->disabled as $e) {
                $alert = new Alert();
                $alert->fill((array)$e);
                $alerts['disable'][] = $alert;
            }
            return $alerts;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }
    public function disable($identifier)
    {
        $this->request->post('/alerts/' . $identifier, array_merge($this->setHeaders(), [
            'query' => ['userId' => Auth::id(), 'enable' => false]
        ]));
    }
    public function enable($identifier)
    {
        $this->request->post('/alerts/' . $identifier, array_merge($this->setHeaders(), [
            'query' => ['userId' => Auth::id(), 'enable' => true]
        ]));
    }

    public function update(string $who, string $body)
    {
        try {
            $response = json_decode($this->request->put('/alerts/' . $who, array_merge($this->setHeaders(), [
                'body' => $body
            ]))->getBody());
            if (property_exists($response, 'token')) {
                session(['token' => $response->token]);
                Auth::user()->token = $response->token;
            }
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    /**
     * @param string $who
     */
    public function destroy(string $who)
    {
        try {
            $this->request->delete('/alerts/' . $who, $this->setHeaders());
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    /**
     * @param string $body
     * @return bool
     */
    public function store(string $body)
    {
        try {
            $this->request->post('', array_merge($this->setHeaders(), [
                'body' => $body
            ]));
            return true;
        } catch (RequestException $e) {
            $this->isExpired($e);
            return false;
        }
    }

    // ===================================================
    // Mockup per un utente
    // Funzione da rimuovere in production

    /**
     * @return Alert
     */
    public static function GetAnAlert()
    {
        $sensor = new Alert();
        $arr = array_combine(
            array('threshold', 'type', 'deleted', 'entity', 'sensor', 'lastSent', 'alertId'),
            array("10", "0", "0", '0', '0', '20-02-2020', '0')
        );
        $sensor->fill($arr);
        return $sensor;
    }
}
