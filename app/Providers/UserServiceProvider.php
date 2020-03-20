<?php


namespace App\Providers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class UserServiceProvider implements UserProvider
{
    //si occupa di prendere lo user dal database
    private $request;

    public function __construct()
    {
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
    public function retrieveById($identifier){
        try {

            $response = json_decode($this->request->get('user/'.$identifier, [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $user = new User();
            $user->fill((array)$response);
            return $user;
        }catch (RequestException $e) {
            if (false/*fai il controllo del token*/)
                Auth::logout();
            else
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
            $this->request = new Client([
                'base_uri' => 'localhost:9999',
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => '{"username":"'.$credentials["email"].'","password":"'.$credentials["password"].'"}'
            ]);
            $response = json_decode($this->request->post('authenticate')->getBody());
            $userarray = (array)$response->user;
            $userarray['token'] = $response->jwt;

            session(['token' => $response->jwt]);
            $user = new User();
            $user->fill($userarray);
            $this->user = $user;
            return $user;
        }catch (RequestException $e) {
            session()->flush();
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
            $response = json_decode($this->request->get('users', [
                'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ]
            ])->getBody());
            $users = [];
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
