<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\UserServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;

class UserController extends Controller
{
    private $provider;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->provider = new UserServiceProvider();
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $users = $this->provider->findAll();
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param $user
     * @return Renderable
     */
    public function show($user)
    {
        $user = $this->provider->retrieveById($user);
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($user)
    {
        $user = $this->provider->retrieveById($user);
        return view('users.edit', compact('user'));
    }

    public function store()
    {
        $data = request()->validate([

        ]);
        $request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . session()->get('token')
            ]
        ]);
        $user = new User();
        $user->fill($data);
        $request->post('/users/create', [
            'body' => $user
        ]);
    }

    public function update($user)
    {
        $data = request()->validate([

        ]);
        $user = $this->provider->retrieveById($user);
        $user->fill($data);
        $request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . session()->get('token')
            ]
        ]);

        $request->put('/user/' . $user->getAuthIdentifier() . '/update', [
            'body' => $user
        ]);
    }


    public function delete($user)
    {
        $request = new Client([
            'base_uri' => 'localhost:9999',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . session()->get('token')
            ]
        ]);
        $request->delete('/user/' . $user);
    }
}
