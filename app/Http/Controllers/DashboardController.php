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
        $entities = $entityProvider->findAll();//enti presenti
        $users = $userProvider->findAll();//utenti registrati
        $devices = $deviceProvider->findAll();//dispositivi registrati
        $entity = null;
        $devicesEntity = [];
        $usersEntity = [];
        $usersActiveEntity = [];

        if ($user->getRole() != 'Amministratore') {
            $entity = $entityProvider->findFromUser($user->getAuthIdentifier());
            $devicesEntity = $deviceProvider->findAllFromEntity($entity->entityId);
            $usersEntity = $userProvider->findAllFromEntity($entity->entityId);
            $usersActiveEntity = array_filter($usersEntity, function ($u) {
                return !$u->deleted;
            });
        }

        $usersActive = array_filter($users, function ($u) {
            return !$u->deleted;
        });
        return view('dashboard.index', compact([
            'user', 'users', 'entities', 'devices', 'devicesEntity', 'usersEntity', 'usersActive', 'usersActiveEntity'
        ]));
    }
}
