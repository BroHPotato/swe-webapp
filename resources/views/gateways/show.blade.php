@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('gateways.show', $gateway->gatewayId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Informazioni Gateway</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('gateways.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Informazioni Gateway</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped table-bordered border-secondary">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Numero di dispositivi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span class="logic-id">{{$gateway->gatewayId}}</span></td>
                            <td>{{$gateway->name}}</td>
                            <td>{{count($devicesWithSensors)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-thermometer-half"></span> Lista dispositivi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped table-bordered border-secondary">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th><span class="fas fa-list-ul"></span></th>
                            <th>Nome</th>
                            <th>Sensori</th>
                            <th>Frequenza</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($devicesWithSensors as $device)
                            <tr>
                                <td> <a href="{{route('devices.show', ['deviceId' => $device['device']->deviceId ])}}" class="logic-id">{{$device['device']->deviceId}}</a></td>
                                <td> <a href="{{route('devices.show', ['deviceId' => $device['device']->deviceId ])}}">{{$device['device']->name}}</a></td>
                                <td>{{count($device['sensors'])}}</td>
                                <td>{{$device['device']->frequency}}s</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
