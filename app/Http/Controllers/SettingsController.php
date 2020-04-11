<?php

namespace App\Http\Controllers;

use App\Providers\AlertServiceProvider;
use App\Providers\DeviceServiceProvider;
use App\Providers\SensorServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $alertsProvider;
    private $devicesProvider;
    private $sensorsProvider;

    public function __construct()
    {
        $this->middleware('auth');
        $this->alertsProvider = new AlertServiceProvider();
        $this->devicesProvider = new DeviceServiceProvider();
        $this->sensorsProvider = new SensorServiceProvider();
    }

    public function edit()
    {
        $user = Auth::user();
        $alerts = $this->alertsProvider->findAll();
        $alertsWithSensors = [];
        $sensorsCache = [];
        foreach ($alerts as $state => $alertsList) {
            foreach ($alertsList as $alert) {
                key_exists($alert->sensor, $sensorsCache) ? $sensor = $sensorsCache[$alert->sensor] : $sensor = $this->sensorsProvider->findFromLogicalId($alert->sensor);
                $alertsWithSensors[$state][] = [
                    'alert' => $alert,
                    'sensor' => $sensor,
                    'device' => $this->devicesProvider->find($sensor->device)
                ];
            }
        }
        return view('settings.edit', compact(['user','alertsWithSensors']));
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
        if (key_exists('telegramName', $data)) {
            if ($data['telegramName'] != $user->getTelegramName()  || is_null($user->getChatId())) {
                $data['tfa'] = false;
            }
        }
        $data = array_diff_assoc($data, $user->getAttributes());
        if (key_exists('new_password', $data)) {
            $data['password'] = $data['new_password'];
        }
        $service = new UserServiceProvider();
        $service->update($user->getAuthIdentifier(), json_encode($data));
        return redirect('/settings/edit');
    }

    public function updateAlerts()
    {
        $alerts = $this->alertsProvider->findAll();
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
            $this->alertsProvider->enable($e);
        }
        foreach ($toDisable as $d) {
            $this->alertsProvider->disable($d);
        }
        return redirect('/settings/edit');
    }
}
