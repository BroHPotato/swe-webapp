@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('device', $device->deviceId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Informazioni dispositivo</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <button class="btn-danger btn" onclick="window.history.back()">Torna indietro</button>
        </div>
            {{--<div class="row">
                <h2>Dispositivo #{{$device->deviceId}}</h2>
            </div>
            @foreach($device->sensorsList as $errorse)
                <div class="row">
                    <h3>Sensore #{{$errorse['sensorId']}}</h3>
                </div>
                <chart-management
                    v-bind:user='{!! json_encode($user) !!}'
                    v-bind:device='{!! json_encode($device) !!}'
                    v-bind:sensor='{!! json_encode($errorse) !!}'
                ></chart-management>
            @endforeach
            --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Informazioni dispositivo</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Gateway</th>
                                <th>Numero di sensori</th>
                                <th>Frequenza</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Termostato</td>
                                <td>US-Gateway</td>
                                <td>4</td>
                                <td>0.5</td>
                                <td><span class="badge badge-success">Attivo</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-thermometer-half"></span> Sensore 1</h6>
                </div>
                <div class="card-body">
                    <div class="col-sm-6 float-left">
                        <div class="form-group row">
                            <label for="SensorId" class="col-sm-6 col-form-label"><span class="fas fa-tag"></span> Id sensore</label>
                            <div class="col-sm-6 col-form-label">
                                <span id="SensorId">1</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="DeviceId" class="col-sm-6 col-form-label"><span class="fas fa-tag"></span> Id dispositivo</label>
                            <div class="col-sm-6 col-form-label">
                                <span id="DeviceId">1</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="SensorType" class="col-sm-6 col-form-label"><span class="fas fa-tape"></span> Tipologia </label>
                            <div class="col-sm-6 col-form-label">
                                <span id="SensorType">Temperatura</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-form-label">
                                <a href="{{route('sensors.show', [
                                        'deviceId' => 1,
                                        'sensorId' => 1
                                    ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-chart-area"></i>
                                        </span>
                                    <span class="text">Mostra grafico</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        OPPURE
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-thermometer-half"></i> Lista sensori</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                        <tr>
                            <th>Id sensore</th>
                            <th>Id dispositivo</th>
                            <th>Tipologia</th>
                            <th>Grafico</th>
                        </tr>
                        </thead>
                        <tfoot class="thead-dark">
                        <tr>
                            <th>Id sensore</th>
                            <th>Id dispositivo</th>
                            <th>Tipologia</th>
                            <th>Grafico</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>Temperatura</td>
                                <td><a href="{{route('sensors.show', [
                                        'deviceId' => 1,
                                        'sensorId' => 1
                                    ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-chart-area"></i>
                                        </span>
                                        <span class="text">Mostra grafico</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
