@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Dispositivi e sensori</h1>
        </div>
        <div class="row">
            <div class="col-auto mb-4 ">
                <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
            @can(['isAdmin'])
                <div class="col-auto mb-4">
                    <a href="{{route('devices.create')}}" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-plus-circle"></span>
                    </span>
                        <span class="text">Aggiungi dispositivo</span>
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
                    <div class="table-responsive-lg">
                        <table class="table table-striped table-bordered border-secondary">
                            <thead class="thead-dark table-borderless">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Status</th>
                                    <th>Gateway</th>
                                    <th>Sensori</th>
                                    <th>Frequenza</th>
                                    <th class="bg-secondary"> </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($deviceOnGateway[1] as $device)
                                <tr>
                                    <td> <a href="{{route('devices.show', ['deviceId' => $device->deviceId ])}}">{{$device->deviceId}}</a></td>
                                    <td> <a href="{{route('devices.show', ['deviceId' => $device->deviceId ])}}">{{$device->name}}</a></td>
                                    <td><span class="badge badge-success">Attivo</span></td>
                                    <td class="small">{{$deviceOnGateway[0]->name}}</td>
                                    <td>{{$deviceOnGateway[2][$device->deviceId]}}</td>
                                    <td>{{$device->frequency}}s</td>
                                    <td class="text-center">
                                        <a href="{{route('devices.edit', ['deviceId' => $device->deviceId ])}}" class="btn btn-sm btn-warning btn-icon-split">
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
        @endforeach
    </div>
@endsection
