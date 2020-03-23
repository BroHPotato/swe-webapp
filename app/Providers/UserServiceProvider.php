<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\RedirectResponse;

class UserServiceProvider extends ServiceProvider implements UserProvider
{
    //si occupa di prendere lo user dal database
    private $request;

    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * @param mixed $identifier
     * @return User|Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        try {
            $response = json_decode($this->request->get('user/' . $identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $user = new User();
            $user->fill((array)$response);
            return $user;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    /**    public function __construct()
    {
    }
     * @param Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * @param array $credentials
     * @return User|Authenticatable|RedirectResponse
     */
    public function retrieveByCredentials(array $credentials)
    {
        try {
            if (key_exists('code', $credentials)) {
                return $this->retriveByCode($this->request, $credentials);
            } else {
                return $this->retriveByCred($this->request, $credentials);
            }
        } catch (RequestException $e) {
            $this->isExpired($e);
            return null;
        }
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials)
    {
        return true;
    }

    public function findAll()
    {
        try {
            $response = json_decode($this->request->get('users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ]
            ])->getBody());
            $users = [];
            foreach ($response as $u) {
                $user = new User();
                $user->fill((array)$u);
                $users[] = $user;
            }
            return $users;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }

    private function retriveByCode(Client $request, $credentials)
    {
        $response = json_decode($request->post('auth/tfa', [
            'headers' => [
                'Authorization' => 'Bearer ' . session()->get('token')
            ],
            'body' => '{"auth_code":"' . $credentials["code"] . '"}'
        ])->getBody());
        $userarray = (array)$response->user;
        $userarray['token'] = $response->jwt;

        session(['token' => $response->jwt]);
        $user = new User();
        $user->fill($userarray);
        return $user;
    }

    private function retriveByCred(Client $request, $credentials)
    {
        $response = json_decode($request->post('auth', [
            'body' => '{"username":"' . $credentials["email"] . '","password":"' . $credentials["password"] . '"}'
        ])->getBody());

        if (property_exists($response, 'tfa')) {
            session(['token' => $response->token]);
            return redirect('/login/tfa');
        } else {
            $userarray = (array)$response->user;
            $userarray['token'] = $response->token;

            session(['token' => $response->token]);
            $user = new User();
            $user->fill($userarray);
            return $user;
        }
    }

    public function update(string $where, string $body)
    {
        try {
            $this->request->put($where . '/update', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token')
                ],
                'body' => $body
            ]);
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
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


    // ===================================================
    // Mockup per un utente
    // Funzione da rimuovere in production

    public function imJustAGuyDontBotherMe()
    {
        $user = new User();
        $arr = array_combine(
            array('userId', 'name', 'surname', 'email', 'type', 'telegramName', 'telegramChat', 'deleted', 'tfa',
                'token'),
            array("1", "sys", "admin", "sys@admin.it", "0", "pippo", "123", "0", "0", "456")
        );
        $user->fill($arr);
        return $user;
    }
}
