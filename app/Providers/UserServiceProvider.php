<?php


namespace App\Providers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;


class UserServiceProvider implements UserProvider
{
    //si occupa di prendere lo user dal database

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private $token;

    /**
     * @param mixed $identifier
     * @return User|Authenticatable|null
     */
    public function retrieveById($identifier){
        try {
            $request = new Client([
                'base_uri' => 'localhost:9999',
                'headers' => [
                    'Content-Type' => 'application/json' ,
                    'Authorization' => 'Bearer '.$_SESSION['token']
                    ]
            ]);
            $response = json_decode($request->get('user/'.$identifier)->getBody());
            $user = new User();
            $user->fill((array)$response);
            return $user;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
        return null;
    }

    /**
     * @param mixed $identifier
     * @param string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token){
        return null;
    }

    /**    public function __construct()
    {
    }
     * @param Authenticatable $user
     * @param string $token
     */
    public function updateRememberToken(Authenticatable $user, $token){

    }

    /**
     * @param array $credentials
     * @return User|Authenticatable|RedirectResponse
     */
    public function retrieveByCredentials(array $credentials){
        try {
            $request = new Client([
                'base_uri' => 'localhost:9999',
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => '{"username":"'.$credentials["email"].'","password":"'.$credentials["password"].'"}'
            ]);
            $response = json_decode($request->post('authenticate')->getBody());
            $userarray = (array)$response->user;
            $userarray['token'] = $response->jwt;

            $this->token = $response->jwt;
            $_SESSION['token'] = $response->jwt;
            $user = new User();
            $user->fill($userarray);
            $this->user = $user;
            return $user;
        }catch (RequestException $e) {
            session_destroy();
            return null;
        }
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials($user, array $credentials){
        return true;
    }

    public function findAll(){
        try {
            $request = new Client([
                'base_uri' => 'localhost:9999',
                'headers' => [
                    'Content-Type' => 'application/json' ,
                    'Authorization' => 'Bearer '.$_SESSION['token']
                ]
            ]);
            $response = json_decode($request->get('users')->getBody());
            foreach ($response as $u){
                $user = new User();
                $user->fill((array)$u);
                $users[] = $user;
            }
            return $users;
        }catch (RequestException $e) {
            abort($e->getCode(), $e->getResponse()->getReasonPhrase());
        }
    }
}
