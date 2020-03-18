<?php


namespace App\Providers;


use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class UserServiceProvider implements UserProvider
{
    //si occupa di prendere lo user dal database
    /**
     * @param mixed $identifier
     * @return User|Authenticatable|null
     */
    public function retrieveById($identifier){
        $request = new Client();

        $response = json_decode($request->get('localhost:9999/user/'.$identifier)->getBody());
        $user = new User();
        $user->fill((array)$response);
        return $user;
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
     * @return User|Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials){
            $request = new Client();
            $response = json_decode($request->post('localhost:9999/auth')->getBody());
            $user = new User();
            $user->fill((array)$response);
            return $user;
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials){
        return true;
    }
}
