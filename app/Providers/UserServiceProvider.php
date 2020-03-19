<?php


namespace App\Providers;


use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class UserServiceProvider extends EloquentUserProvider
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
        try {
            $request = new Client([
                'base_uri' => 'localhost:9999',
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => '{"username":"'.$credentials["email"].'","password":"'.$credentials["password"].'"}'
            ]);
            $response = json_decode($request->post('authenticate')->getBody());
            $user = new User();
            $userarray = (array)$response->user;
            $userarray['token'] = $response->jwt;
            $user->fill($userarray);
            return $user;
        }catch (RequestException $e) {
            dd($e);
        }
        return null;
    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials){
        return true;
    }

    public function findAllFrom(Authenticatable $user){
        return array("" => $user);
    }
}
