@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('entities.show', $entity->name))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Informazioni ente</h1>
        </div>
        <div class="row">
            <div class="col-auto mb-4 ">
                <a href="{{route('entities.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary"><span class="fas fa-building"></span>Informazioni ente</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Nome</th>
                            <th>Luogo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>{{$entity->name}}</th>
                            <th>{{$entity->location}}</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-users"></span> Lista utenti</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Prova</td>
                            <td>Provina</td>
                            <td>prova@provina.com</td>
                        </tr>
                        <tr>
                            <td>Prova1</td>
                            <td>Provina1</td>
                            <td>prova1@provina.com</td>
                        </tr>
                        <tr>
                            <td>Prova2</td>
                            <td>Provina2</td>
                            <td>prova2@provina.com</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

