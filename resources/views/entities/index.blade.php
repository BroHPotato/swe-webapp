@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('entities.index'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Enti </h1>
        </div>
        @include('layouts.error')
        <div class="row">
            <div class="col-auto mb-4">
                <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                              <span class="fas fa-arrow-circle-left"></span>
                            </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
            @can(['isAdmin'])
                <div class="col-auto mb-4">
                    <a href="{{route('entities.create')}}" class="btn btn-sm btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-plus-circle"></span>
                        </span>
                        <span class="text">Aggiungi ente</span>
                    </a>
                </div>
        </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-city"></span> Lista enti</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-bordered table-striped"  id="dataTable" >
                            <thead class="thead-dark table-borderless">
                            <tr>
                                <th>Nome</th>
                                <th>Luogo</th>
                                <th>Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
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
                                                    'entityId' => $entity->entityId
                                            ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                            <span class="text">Dettagli</span>
                                        </a>
                                    </td>
                                    <td class="text-center"><a href="{{route('entities.edit', ['entityId' => $entity->entityId])}}" class="btn btn-warning btn-icon-split">
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

