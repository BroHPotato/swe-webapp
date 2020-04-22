@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('entities.index'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Enti </h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('dashboard.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        @can(['isAdmin'])
            <div class="d-sm-flex mb-4 ml-sm-auto">
                <a href="{{route('entities.create')}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-plus-circle"></span>
                    </span>
                    <span class="text">Aggiungi</span>
                </a>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-city"></span> Lista enti</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark table-borderless">
                            <tr>
                                <th>Nome</th>
                                <th>Luogo</th>
                                <th>Status</th>
                                <th> </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot class="thead-dark table-borderless">
                            <tr>
                                <th>Nome</th>
                                <th>Luogo</th>
                                <th>Status</th>
                                <th> </th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($entities as $entity)
                                <tr>
                                    <td>{{$entity->name}}</td>
                                    <td>{{$entity->location}}</td>
                                    <td>@if($entity->deleted===true)
                                            <span class="badge badge-danger">Eliminato</span>
                                        @else
                                            <span class="badge badge-success">Attivo</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><a href="{{route('entities.show', [
                                                    'entityName' => $entity->name
                                            ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                            <span class="text">Dettagli</span>
                                        </a>
                                    </td>
                                    <td class="text-center"><a href="{{route('entities.edit', ['entityName' => $entity->name])}}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-edit"></span>
                                        </span>
                                            <span class="text">Modifica</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

