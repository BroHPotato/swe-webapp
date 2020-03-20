<?php

namespace App\Http\Controllers;

use App\Providers\UserServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

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
        return view('devices.show', compact('user'));
    }
}
