<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Providers\UserServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update()
    {
        $user = Auth::user();
        $data = request()->validate([
            'email' => 'email',
            'telegramName' => 'nullable|string|required_if:tfa,==,true',
            'tfa' => 'nullable|in:true',
            'password' => 'required_with:new_password|in:' . $user->getAuthPassword(),
            'new_password' => 'required_with:password|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password'
        ]);

        if (key_exists('tfa', $data)) {
            $data['tfa'] = boolval($data['tfa']);
        } else {
            $data['tfa'] = false;
        }
        if ($data['telegramName'] != $user->getTelegramName()  || is_null($user->getChatId())) {
            $data['tfa'] = false;
        }

        $user->fill($data);
        $service = new UserServiceProvider();
        $service->update($user->getAuthIdentifier(), $user);
        Auth::login($user);
        return redirect('/settings/edit');
    }
}
