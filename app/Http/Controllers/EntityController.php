<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Providers\EntityServiceProvider;
use App\Providers\UserServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class EntityController extends Controller
{
    private $entityProvider;
    private $usersProvider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->entityProvider = new EntityServiceProvider();
        $this->usersProvider = new UserServiceProvider();
    }

    public function create()
    {
        $entities = $this->entityProvider->findAll();
        return view('entities.create', compact(['entities']));
    }

    public function edit($entity)
    {
        $entity = $this->entityProvider->find($entity);
        return view('entities.edit', compact('entity'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $entities = $this->entityProvider->findAll();
        return view('entities.index', compact('entities'));
    }

    /**
     * Display the specified resource.
     *
     * @param $entity
     * @return Factory|View
     */
    public function show($entityId)
    {
        $entity = $this->entityProvider->find($entityId);
        $users = $this->usersProvider->findAllFromEntity($entity->entityId) ?? [];
        return view('entities.show', compact(['entity', 'users']));
    }

    public function update($entityId)
    {
        $data = request()->validate([
            'name' => 'required|string',
            'location' => 'required|string'
        ]);
        return $this->entityProvider->update($entityId, json_encode($data)) ?
            redirect(route('entities.index'))->withErrors(['GoodUpdate' => 'Ente aggiornato con successo']) :
            redirect(route('entities.index'))->withErrors(['NotUpdate' => 'Ente non aggiornato']);
    }
    public function destroy($entityId)
    {
        return $this->entityProvider->destroy($entityId) ?
            redirect(route('entities.index'))->withErrors(['GoodDestroy' => 'Ente eliminato con successo']) :
            redirect(route('entities.index'))->withErrors(['NotDestroy' => 'Ente non eliminato']);
    }
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'location' => 'required|string'
        ]);
        return $this->entityProvider->store(json_encode($data)) ?
            redirect(route('entities.index'))->withErrors(['GoodUpdate' => 'Ente creato con successo']) :
            redirect(route('entities.index'))->withErrors(['NotUpdate' => 'Ente non creato']);
    }
}
