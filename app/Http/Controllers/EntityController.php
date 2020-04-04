<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Providers\EntityServiceProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class EntityController extends Controller
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
        $this->provider = new EntityServiceProvider();
    }

    public function create()
    {
        $entities = $this->provider->findAll();
        return view('entities.create', compact(['entities']));
    }

    public function edit($entity)
    {
        //$device = $this->provider->find($device);
        ///FAKER
        $entity = new Entity();
        $arr = array_combine(
            array('entityId', 'name', 'location', 'deleted'),
            array("1", "CasaDiMariano", "Padova", false)
        );
        $entity->fill($arr);
        //TODO remove
        return view('entities.edit', compact('entity'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $entities = $this->provider->findAll();
        return view('entities.index', compact('entities'));
    }

    /**
     * Display the specified resource.
     *
     * @param $entity
     * @return Factory|View
     */
    public function show($entity)
    {
        //$entity = $this->provider->retrieveById($entity);
        //FAKER
        $entity = new Entity();
        $arr = array_combine(
            array('entityId', 'name', 'location', 'deleted'),
            array("1", "CasaDiMariano", "Padova", false)
        );
        $entity->fill($arr);
        //TODO remove
        return view('entities.show', compact('entity'));
    }
}
