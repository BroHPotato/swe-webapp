<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $provider;

    public function __construct()
    {
        $this->middleware('auth');
        $this->provider = new AlertServiceProvider();
    }

    public function edit()
    {
        $user = Auth::user();
        $alerts = $this->provider->findAll();
        return view('settings.edit', compact(['user','alerts']));
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
        }
        if ($data['telegramName'] != $user->getTelegramName()  || is_null($user->getChatId())) {
            $data['tfa'] = false;
        }
        $data = array_diff_assoc($data, $user->getAttributes());
        $service = new UserServiceProvider();
        $service->update($user->getAuthIdentifier(), json_encode($data));
        return redirect('/settings/edit');
    }

    public function updateAlerts()
    {
        $alerts = $this->provider->findAll();
        $data = request()->validate([
            'alerts.*' => 'required|numeric'
        ])['alerts'];
        $enable = [];
        $disable = [];
        foreach ($alerts['enable'] as $a) {
            $enable[] = $a->alertId;
        }
        foreach ($alerts['disable'] as $a) {
            $disable[] = $a->alertId;
        }
        $toEnable = array_diff($data, $enable);
        $toDisable = array_diff($enable, $data);
        foreach ($toEnable as $e) {
            $this->provider->enable($e);
        }
        foreach ($toDisable as $d) {
            $this->provider->disable($d);
        }
        return redirect('/settings/edit');
    }
}
