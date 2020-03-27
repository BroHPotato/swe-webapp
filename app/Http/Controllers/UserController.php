<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\UserServiceProvider;
use Illuminate\Contracts\Support\Renderable;
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
            'name' => 'required|string',
            'surname' => 'required|string',
            'type' => 'required|in:1,2,3|numeric',
            'email' => 'required|email',
            'telegramName' => 'nullable|string|required_if:tfa,==,true',
            'telegramChat' => 'nullable|string|required_if:tfa,==,true',
            'tfa' => 'nullable|in:true',
            'deleted' => 'nullable|in:true',
            'password' => 'nullable|min:6',
            'password_check' => 'required|in:' . Auth::user()->getAuthPassword(),
        ]);

        if (key_exists('deleted', $data)) {
            $data['deleted'] = boolval($data['deleted']);
        } else {
            $data['deleted'] = false;
        }

        if (key_exists('tfa', $data)) {
            $data['tfa'] = boolval($data['tfa']);
        } else {
            $data['tfa'] = false;
        }
        $user = new User();
        $user->fill($data);
        $this->provider->store($user);
    }

    public function update($user)
    {
        $user = $this->provider->retrieveById($user);
        $data = request()->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'type' => 'required|in:1,2,3|numeric',
            'email' => 'required|email',
            'telegramName' => 'nullable|string|required_if:tfa,==,true',
            'telegramChat' => 'nullable|string|required_if:tfa,==,true',
            'tfa' => 'nullable|in:true',
            'deleted' => 'nullable|in:true',
            'password' => 'nullable|min:6',
            'password_check' => 'required|in:' . Auth::user()->getAuthPassword(),
        ]);

        if (key_exists('deleted', $data)) {
            $data['deleted'] = boolval($data['deleted']);
        } else {
            $data['deleted'] = false;
        }

        if (key_exists('tfa', $data)) {
            $data['tfa'] = boolval($data['tfa']);
        } else {
            $data['tfa'] = false;
        }
        if ($data['telegramName'] != $user->getTelegramName()  || is_null($user->getChatId())) {
            $data['tfa'] = false;
        }
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
