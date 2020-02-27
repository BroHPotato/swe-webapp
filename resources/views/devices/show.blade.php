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
                :user='{!! json_encode($user) !!}'
                :device='{!! json_encode($device) !!}'
                :sensor='{!! json_encode($sensore) !!}'
            ></chart-management>
        @endforeach
    </div>
@endsection
