@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Dispositivi</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-hdd"></i> Lista dispositivi</h6>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Dispositivo</th>
                        <th>Nome</th>
                        <th># Sensori</th>
                        <th>Ente</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Dispositivo</th>
                        <th>Nome</th>
                        <th># Sensori</th>
                        <th>Ente</th>
                        <th> </th>
                        <th> </th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @foreach($devices as $device)
                            <tr>
                                <td><span class="badge badge-success">Attivo</span></td>
                                <td>{{$device->deviceId}}</td>
                                <td>{{$device->name}}</td>
                                <td>{{ "TBD" }}</td>
                                <td>{{ "TBD" }}</td>
                                <td><a href="{{route('sensors.index', ['deviceId' => $device->deviceId ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-thermometer-half"></i>
                                        </span>
                                        <span class="text">Sensori</span>
                                    </a>
                                </td>
                                <td><a href="{{route('devices.show', ['deviceId' => $device->deviceId ])}}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-info-circle"></i>
                                        </span>
                                        <span class="text">Dettagli</span>
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
