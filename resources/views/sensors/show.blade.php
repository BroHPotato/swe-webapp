@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('sensor', $device->deviceId, $sensor->realSensorId))
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h4 mb-0 text-gray-800"> Sensore <span class="real-id">{{$sensor->realSensorId}}</span> del dispositivo <span class="logic-id">{{$sensor->device}}</span> </h1>
    </div>

    <!-- TODO: realSensorId da cambiare con l'ID logico -->

    <div class="d-inline-block mt-2 mb-4 px-0">
        <a href="{{route('devices.show', $sensor->realSensorId)}}" class="btn btn-sm btn-danger btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-arrow-circle-left"></span>
                </span>
            <span class="text">Torna indietro</span>
        </a>
    </div>

    <div class="row">
         <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-chart-area"></span> Dato sensore real-time</h6>
                </div>
                <div class="card-body">
                    <single-chart
                    :sensor="{{json_encode($sensor)}}"
                    ></single-chart>
                </div>
            </div>
         </div>
    </div>
</div>
@endsection
