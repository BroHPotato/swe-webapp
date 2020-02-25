@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="div">ecco i tuoi devices</div>
        <div class="d-flex">
            @foreach($devices as $device)
                <div class="col">
                    <div class="card">
                        <a href="/user/{{ $user->id.'/devices/'.$device->nome}}">
                            <div class="card-header">
                                <h2>{{$device->nome}}</h2>
                            </div>
                        </a>
                        <div class="card-body">
                            <h3>Sensori disponibili</h3>
                            @foreach($device->sensori as $sensore)
                                <p>{{$sensore['nome']}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
