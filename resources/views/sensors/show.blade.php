@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('sensor', $device->deviceId, $sensor->realSensorId))
@section('content')
    <div class="d-sm-flex mb-4">
        <h1 class="h4 mb-0 text-gray-800"> Sensore #{{$sensor->realSensorId}} del dispositivo #{{$sensor->device}} </h1>
    </div>

    <div class="d-inline-block my-2 px-0">
        <a href="#" class="btn btn-sm btn-danger btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-arrow-circle-left"></span>
                </span>
            <span class="text">Torna indietro</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-chart-area"></span> Dato sensore real-time</h6>
        </div>
        <div class="card-body">
            <double-chart
                :sensor1="{{json_encode($sensor)}}"
                :sensor2="{{json_encode($sensor)}}"
            ></double-chart>
        </div>
    </div>
@endsection
