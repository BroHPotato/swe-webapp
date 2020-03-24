<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\UserServiceProvider;
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
            //TODO
        ]);
        $user = new User();
        $user->fill($data);
        $this->provider->store($user);
    }

    public function update($user)
    {
        $data = request()->validate([
            //TODO
        ]);
        $user = $this->provider->retrieveById($user);
        $user->fill($data);
        $this->provider->update($user->getAuthIdentifier(), $user);
    }

    public function destroy($user)
    {
        $user = $this->provider->retrieveById($user);
        $user->setDeleted(true);
        $this->provider->destroy($user->getAuthIdentifier(), $user);
    }

    public function restore($user)
    {
        $user = $this->provider->retrieveById($user);
        $user->setDeleted(false);
        $this->provider->update($user->getAuthIdentifier(), $user);
    }
}
