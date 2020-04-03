<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

use function config;

/**
 * Class UserServiceProvider
 * @package App\Providers
 */
class UserServiceProvider extends ServiceProvider implements UserProvider
{
    //si occupa di prendere lo user dal database
    /**
     * @var Client
     */
    private $request;

    /**
     * UserServiceProvider constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->request = new Client([
            'base_uri' => config('app.api'),
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
            $response = json_decode($this->request->get('users/' . $identifier, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ])->getBody());
            $user = new User();
            $user->fill((array)$response);
            return $user;
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
            return null;
        }
    }

    /**
     * @param RequestException $e
     * @return RedirectResponse|Redirector
     */
    private function isExpired(RequestException $e)
    {
        if ($e->getCode() == 419/*fai il controllo del token*/) {
            session()->invalidate();
            session()->flush();
            return redirect('login');
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
     * {
     * }
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
     * @param Client $request
     * @param $credentials
     * @return User
     */
    private function retriveByCode(Client $request, $credentials)
    {
        $response = json_decode($request->post('auth/tfa', [
            'headers' => [
                'Authorization' => 'Bearer ' . session()->get('token'),
                'X-Forwarded-For' => request()->ip()
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

    /**
     * @param Client $request
     * @param $credentials
     * @return User|RedirectResponse|Redirector
     */
    private function retriveByCred(Client $request, $credentials)
    {
        $response = json_decode($request->post('auth', [
            'headers' => [
                'X-Forwarded-For' => request()->ip()
            ],
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

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials)
    {
        return true;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        try {
            $response = json_decode($this->request->get('users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
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

    /**
     * @param $entityId
     * @return array
     */
    public function findAllFromEntity($entityId)
    {
        try {
            $response = json_decode($this->request->get('users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ],
                'query' => 'entityId=' . $entityId
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

    /**
     * @param string $who
     * @param string $body
     */
    public function update(string $who, string $body)
    {
        try {
            $response = json_decode($this->request->put('/users/' . $who, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ],
                'body' => $body
            ])->getBody());
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
            $this->request->delete('/users/' . $who, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ]
            ]);
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
            $this->request->post('users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session()->get('token'),
                    'X-Forwarded-For' => request()->ip()
                ],
                'body' => $body
            ]);
        } catch (RequestException $e) {
            $this->isExpired($e);
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }


    // ===================================================
    // Mockup per un utente
    // Funzione da rimuovere in production

    /**
     * @return User
     */
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
