@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('sensor', $device->deviceId, $sensor->realSensorId))
@section('content')
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Sensore {{$sensor->realSensorId}} del dispositivo {{$sensor->device}} </h1>
    </div>
    <div class="d-sm-flex mb-4 ml-sm-auto">
        <button class="btn-danger btn" onclick="window.history.back()">Torna indietro</button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-chart-area"></span> Dati real-time</h6>
        </div>
        <div class="card-body">
            <chart-management
                :sensor1="{{json_encode($sensor)}}"
                :sensor2="{{json_encode($sensor)}}"
            ></chart-management>
        </div>
    </div>

@endsection
