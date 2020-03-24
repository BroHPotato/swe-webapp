<?php

namespace App\Http\Controllers;

use App\Providers\DeviceServiceProvider;
use App\Providers\EntityServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $userProvider = new UserServiceProvider();
        $entityProvider = new EntityServiceProvider();
        $deviceProvider = new DeviceServiceProvider();

        $user = Auth::user();
        $users = $userProvider->findAll();//utenti registrati
        $entities = $entityProvider->findAll();//enti presenti
        $devices = $deviceProvider->findAll();//dispositivi registrati

        $devicesEntity = $deviceProvider->findAllFromEntity($entityProvider->findFromUser($user->getAuthIdentifier()));
        $usersEntity = $userProvider->findAllFromEntity($entityProvider->findFromUser($user->getAuthIdentifier()));

        $usersActive = array_filter($users, function ($u) {
            return !$u->deleted;
        });
        $usersActiveEntity = array_filter($usersEntity, function ($u) {
            return !$u->deleted;
        });
        return view('dashboard.index', compact([
            'user', 'users', 'entities', 'devices', 'devicesEntity', '$usersEntity', 'usersActive', 'usersActiveEntity'
        ]));
    }
}
