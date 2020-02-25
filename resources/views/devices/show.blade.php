@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2>{{$device->nome}}</h2>
        </div>
        @foreach($device->sensori as $sensore)
            <div class="row">
                <h3>{{$sensore['nome']}}</h3>
                <canvas class="RTChart" id="{{$sensore['nome']}}" width="1300" height="300"></canvas>
            </div>
        @endforeach
    </div>
@endsection
