@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2>{{$device->nome}}</h2>
        </div>
        @foreach($device->sensori as $sensore)
            <div class="row">
                <h3>{{$sensore['nome']}}</h3>
            </div>
            <chart-management
                v-bind:user='{!! json_encode($user) !!}'
                v-bind:device='{!! json_encode($device) !!}'
                v-bind:sensor='{!! json_encode($sensore) !!}'
            ></chart-management>
        @endforeach
    </div>
@endsection
