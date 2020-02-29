@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2>{{$device->deviceId}}</h2>
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
    </div>
@endsection
