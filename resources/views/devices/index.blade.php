@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Dispositivi</h1>
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
                <a href="{{route('devices.create')}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-plus-circle"></span>
                    </span>
                    <span class="text">Aggiungi</span>
                </a>
            </div>
        @endcan
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Lista dispositivi</h6>
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
                            <th> </th>
                            <th> </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($devices as $device)
                            <tr>
                                <td>{{$device->deviceId}}</td>
                                <td>{{$device->name}}</td>
                                <td>{{$device->gatewayId}}</td>
                                <td>{{count($device->getSensors())}}</td>
                                <td>{{$device->frequency}}</td>
                                <td><a href="{{route('devices.show', ['deviceId' => $device->deviceId])}}" class="btn btn-primary btn-icon-split float-right">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                        <span class="text">Dettagli</span>
                                    </a>
                                </td>
                                <td><a href="{{route('devices.edit', ['deviceId' => $device->deviceId ])}}" class="btn btn-warning btn-icon-split float-right">
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
    </div>
@endsection
