@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('gateways'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Gateway </h1>
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
                <a href="{{route('gateways.create')}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-plus-circle"></span>
                    </span>
                    <span class="text">Aggiungi</span>
                </a>
            </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-dungeon"></span> Lista gateway</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless`">
                        <tr>
                            <th>ID </th>
                            <th>Nome</th>
                            <th>Numero Dispositivi</th>
                            <th> </th>
                            <th> </th>
                            <th>Configurazione</th>
                        </tr>
                        </thead>
                        <tfoot class="thead-dark table-borderless">
                        <tr>
                            <th>ID </th>
                            <th>Nome</th>
                            <th>Numero Dispositivi</th>
                            <th> </th>
                            <th> </th>
                            <th>Configurazione</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($gateways as $gateway)
                            <tr>
                                <td>{{$gateway->gatewayId}}</td>
                                <td>{{$gateway->name}}</td>
                                <td>2</td>  {{-- IL NUMERO DI DISPOSITIVI VA PRESO DINAMICAMENTE --}}
                                <td><a href="{{route('gateways.show', [
                                                    'gatewayId' => $gateway->gatewayId
                                            ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                        <span class="text">Dettagli</span>
                                    </a>
                                </td>
                                <td><a href="{{route('gateways.edit', ['gatewayId' => $gateway->gatewayId ])}}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-edit"></span>
                                        </span>
                                        <span class="text">Modifica</span>
                                    </a>
                                </td>
                                <td><a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-paper-plane"></span>
                                        </span>
                                        <span class="text">Invia</span>
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
