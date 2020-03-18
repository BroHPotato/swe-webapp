<?php

namespace App\Http\Controllers;

use App\Providers\UserServiceProvider;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user)
    {
        $user = $this->provider->retrieveById($user);
        return view('users.index', compact('user'));
    }
}
