@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('device', $device->deviceId))
@section('content')
    <div class="d-sm-flex mb-4 ml-sm-auto">
        <button class="btn-danger btn" onclick="window.history.back()">Torna indietro</button>
    </div>
        {{--<div class="row">
            <h2>Dispositivo #{{$device->deviceId}}</h2>
        </div>
        @foreach($device->sensorsList as $sensore)
            <div class="row">
                <h3>Sensore #{{$sensore['sensorId']}}</h3>
            </div>
            <chart-management
                v-bind:user='{!! json_encode($user) !!}'
                v-bind:device='{!! json_encode($device) !!}'
                v-bind:sensor='{!! json_encode($sensore) !!}'
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
                            <th># Sensori</th>
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
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-thermometer-empty"></span> Sensore 1</h6>
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
                        <label for="SensorType" class="col-sm-6 col-form-label"><span class="fas fa-tape"></span> Tipo di sensore</label>
                        <div class="col-sm-6 col-form-label">
                            <span id="SensorType">Temperatura</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 float-right">
                    <div class="form-group row">
                        <label for="Chart" class="col-sm col-form-label text-center"><span class="fas fa-chart-line"></span> Grafico </label>
                    </div>
                    <div class="row">
                        {{--GRAFICO--}}
                        grafico
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
