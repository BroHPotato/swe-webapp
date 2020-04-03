@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Dispositivi</h1>
        </div>
        <div class="row">
            <div class="col-auto mb-4 ">
                <a href="{{route('dashboard.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
            @can(['isAdmin'])
                <div class="col-auto mb-4">
                    <a href="{{route('devices.create')}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-plus-circle"></span>
                    </span>
                        <span class="text">Aggiungi</span>
                    </a>
                </div>
            @endcan
        </div>

        @foreach($devicesOnGateways as $deviceOnGateway)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Lista dispositivi {{ $deviceOnGateway[0]->name}}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark table-borderless">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Gateway</th>
                                <th>Numero di sensori</th>
                                <th>Frequenza</th>
                                <th>Status</th>
                                <th> </th>
                                <th> </th>
                            </tr>
                            </thead>
                            <tfoot class="thead-dark table-borderless">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Gateway</th>
                                <th>Numero di sensori</th>
                                <th>Frequenza</th>
                                <th>Status</th>
                                <th> </th>
                                <th> </th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($deviceOnGateway[1] as $device)
                                <tr>
                                    <td>{{$device->deviceId}}</td>
                                    <td>{{$device->name}}</td>
                                    <td>{{$deviceOnGateway[0]->name}}</td>
                                    <td>{{$deviceOnGateway[2][$device->deviceId]}}</td>
                                    <td>{{$device->frequency}}</td>
                                    <td><span class="badge badge-success">Attivo</span></td>
                                    <td class="text-center"><a href="{{route('devices.show', ['deviceId' => $device->deviceId ])}}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-thermometer-half"></span>
                                        </span>
                                        <span class="text">Sensori</span>
                                    </a>
                                </td>
                                <td><a href="{{route('devices.show', ['deviceId' => $device->deviceId ])}}" class="btn btn-primary btn-icon-split float-right">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                            <span class="text">Dettagli</span>
                                        </a>
                                    </td>
                                    <td class="text-center"><a href="{{route('devices.edit', ['deviceId' => $device->deviceId ])}}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-plus-circle"></span>
                                        </span>
                    <span class="text">Invia configurazione</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Lista dispositivi DE-Gateway</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Gateway</th>
                            <th>Numero di Sensori</th>
                            <th>Frequenza</th>
                            <th>Status</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tfoot class="thead-dark table-borderless">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Gateway</th>
                            <th>Numero di Sensori</th>
                            <th>Frequenza</th>
                            <th>Status</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Termostato</td>
                            <td>DE-Gateway</td>
                            <td>4</td>
                            <td>0.5</td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td class="text-center"><a href="{{route('devices.show', ['deviceId' => 1 ])}}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                    <span class="text">Dettagli</span>
                                </a>
                            </td>
                            <td class="text-center"><a href="{{route('devices.edit', ['deviceId' => 1 ])}}" class="btn btn-primary btn-icon-split">
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
                    <a href="#" class="btn btn-success btn-icon-split float-right">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-plus-circle"></span>
                                        </span>
                        <span class="text">Invia configurazione</span>
                    </a>
                </div>
                <a href="#" class="btn btn-success btn-icon-split float-right">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-plus-circle"></span>
                                        </span>
                    <span class="text">Invia configurazione</span>
                </a>
            </div>
        @endforeach
    </div>
@endsection
