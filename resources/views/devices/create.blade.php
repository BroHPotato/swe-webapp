@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices.create'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Aggiunta dispositivo</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('devices.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                   <span class="icon text-blue-50">
                          <span class="fas fa-plus-circle"></span>
                   </span>
                    Aggiunta dispositivo
                </h6>
            </div>
            @can(['isAdmin'])
                <div id="cardDispositivo" class="card-body">
                    <p>Puoi modificare il dispositivo inserendo le informazioni elencate di seguito:</p>
                    <form method="POST" action="{{route('devices.store')}}" id="create">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="inputDeviceId" class="col-sm-3 col-form-label"><span class="fas fa-microchip"></span> Id dispositivo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('realDeviceId') is-invalid @enderror" id="inputDeviceId" placeholder="Id dispositivo" value="{{old('realDeviceId')}}" name="realDeviceId">
                                @error('realDeviceId')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDeviceName" class="col-sm-3 col-form-label"><span class="fas fa-tag"></span> Nome dispositivo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputDeviceName" placeholder="Nome dispositivo" value="{{old("name")}}" name="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputGatewayName" class="col-sm-3 col-form-label"><span class="fas fa-dungeon"></span> Nome gateway</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <select class="form-control @error('gatewayId') is-invalid @enderror" name="gatewayId" id="inputGatewayName">
                                        @foreach($gateways as $gateway)
                                            <option value="{{$gateway->gatewayId}}">{{$gateway->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('gatewayId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputFrequency" class="col-sm-3 col-form-label"><span class="fas fa-history"></span> Frequenza ricezione dati</label>
                            <div class="col-sm-9">
                                <div class="input-group mb-3">
                                    <select class="form-control @error('frequency') is-invalid @enderror" name="frequency" id="inputFrequency">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    @error('frequency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">Secondi</span>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div id="sensorsList">
                            @foreach(old('sensorId')??[] as $key => $Id)
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">
                                        <span class="fas fa-thermometer-half mx-1"></span>Sensore <span class="real-id">{{$Id}}</span>
                                    </label>
                                    <label class="col-lg-2 col-form-label">
                                        <span class="fas fa-tag mx-1"></span>Id sensore
                                    </label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" placeholder="Id sensore" value="{{$Id}}" name="sensorId[]">
                                    </div>
                                    <label class="col-lg-2 col-form-label">
                                        <span class="fas fa-tape mx-1"></span>Tipologia
                                    </label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" placeholder="Tipo di sensore" value="{{old('sensorType')[$key]}}" name="sensorType[]">
                                    </div>
                                    <div class="col-lg-1 col-form-label text-center d-none d-lg-block">
                                        <span class="fas fa-trash text-danger delete"></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                    @endcan
                </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                   <span class="icon text-blue-50">
                          <span class="fas fa-plus-circle"></span>
                   </span>
                    Aggiunta sensore
                </h6>
            </div>
            @can(['isAdmin'])
                <div id="cardSensore" class="card-body">
                    <p>Puoi creare un nuovo sensore inserendo le informazioni elencate in seguito:</p>
                    <form method="POST"id="sensorForm">
                        <div class="form-group row">
                            <label for="inputSensorId" class="col-sm-3 col-form-label"><span class="fas fa-tag"></span> Id sensore</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('sensorId') is-invalid @enderror" id="inputSensorId" placeholder="Id sensore" value="" name="sensorId[]">
                                @error('sensorId')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSensorType" class="col-sm-3 col-form-label"><span class="fas fa-tape"></span>Tipologia</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('sensorType') is-invalid @enderror" id="inputSensorType" placeholder="Tipo di sensore" value="" name="sensorType[]">
                                @error('sensorType')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mx-1 float-right">
                            <button id="addSensor" type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                  <span class="fas fa-plus-circle"></span>
                                </span>
                                <span class="text">Aggiungi sensore</span>
                            </button>
                        </div>
                    </form>
                    @endcan
                </div>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto float-right">
            <button type="submit" class="btn btn-success btn-icon-split" form="create">
                        <span class="icon text-white-50">
                          <span class="fas fa-save"></span>
                        </span>
                <span class="text">Salva</span>
            </button>
        </div>
    </div>


@endsection
