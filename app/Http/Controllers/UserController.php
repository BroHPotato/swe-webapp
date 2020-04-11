<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Providers\EntityServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @var UserServiceProvider
     */
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
        $entities = (new EntityServiceProvider())->findAll();
        $nullOrNot = function ($u) use (&$entities) {
            $entity = array_filter($entities, function ($e) use (&$u) {
                return $u->entity == $e->entityId;
            });
            if (empty($entity)) {
                return null;
            }
            return array_pop($entity);
        };

        foreach ($users as $u) {
            $usersWithEntity[] = ['user' => $u, 'entity' => $nullOrNot($u)];
        }
        return view('users.index', compact('usersWithEntity'));
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

    /**
     * @return Factory|View
     */
    public function create()
    {
        $entityProvider = new EntityServiceProvider();
        $entities = $entityProvider->findAll();
        return view('users.create', compact('entities'));
    }

    /**
     * @param $user
     * @return Factory|View
     */
    public function edit($user)
    {
        $user = $this->provider->retrieveById($user);
        return view('users.edit', compact('user'));
    }

    /**
     *
     */
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'email' => 'required|email|max:32',
            'entityId' => 'nullable|numeric|required_if:' . Auth::user()->getRole() . ',==,Admin',
            'type' => 'nullable|numeric|required_if:' . Auth::user()->getRole() . ',==,Admin',
        ]);
        $data['password'] = "password";
        if (!key_exists('entityId', $data)) {
            $data['entityId'] = (new EntityServiceProvider())->findFromUser(Auth::id())->entityId;
        }
        if (!key_exists('type', $data)) {
            $data['type'] = 0;
        }
        return $this->provider->store(json_encode($data)) ? redirect(route('users.index')) :
            redirect(route('users.index'))->withErrors(['createError' => 'Operazione non andata a buon fine']);
    }

    /**
     * @param $user
     * @return RedirectResponse|Redirector
     */
    public function update($user)
    {
        $user = $this->provider->retrieveById($user);
        $data = request()->validate([
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'type' => 'in:1,2,3|numeric|required_if:' . Auth::user()->getRole() . '==, "isAdmin"',
            'email' => 'required|email|max:32',
            'telegramName' => 'nullable|string|required_if:tfa,==,true',
            'tfa' => 'nullable|in:true',
            'deleted' => 'nullable|in:true',
            'password' => 'nullable|min:6',
        ]);
        $data = array_diff_assoc($data, $user->getAttributes());

        if (key_exists('deleted', $data)) {
            $data['deleted'] = boolval($data['deleted']);
        } else {
            $data['deleted'] = false;
        }

        if (key_exists('tfa', $data)) {
            $data['tfa'] = boolval($data['tfa']);
        }

        if (key_exists('telegramName', $data)) {
            if ($data['telegramName'] != $user->getTelegramName()) {
                $data['tfa'] = false;
            }
        }

        $this->provider->update($user->getAuthIdentifier(), json_encode($data, JSON_FORCE_OBJECT));
        return redirect(route('users.index'));
    }

    /**
     * @param $userId
     * @return RedirectResponse|Redirector
     */
    public function destroy($userId)
    {
        $this->provider->destroy($userId);
        return redirect(route('users.index'));
    }

    /**
     * @param $userId
     * @return RedirectResponse|Redirector
     */
    public function restore($userId)
    {
        $user = $this->provider->retrieveById($userId);
        $this->provider->update($user->getAuthIdentifier(), '{"deleted":false}');
        return redirect(route('users.index'));
    }
}
