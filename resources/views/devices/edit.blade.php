@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices.edit', $device->deviceId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Modifica dispositivo</h1>
        </div>

            <div class="d-sm-inline-flex mb-4 ml-sm-auto">
                <a href="{{route('devices.index')}}" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                              <span class="fas fa-arrow-circle-left"></span>
                            </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
            <div class="d-sm-inline-flex mb-4 ml-sm-auto float-right">
                <button class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-trash"></span>
                                        </span>
                    <span class="text">Elimina</span>
                </button>
            </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                   <span class="icon text-blue-50">
                          <span class="fas fa-plus-circle"></span>
                   </span>
                    Modifica dispositivo
                </h6>
            </div>
            @can(['isAdmin'])
                <div id="cardDispositivo" class="card-body">
                    <p>Puoi modificare un dispositivo inserendo le informazioni elencate in seguito:</p>
                    <form method="POST" action="{{--route('devices.update', $device->deviceId)--}}">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="inputDeviceId" class="col-sm-3 col-form-label"><span class="fas fa-microchip"></span> Id dispositivo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('deviceId') is-invalid @enderror" id="inputDeviceId" placeholder="Id dispositivo" value="{{old('deviceId')??$device->deviceId}}" name="deviceid">
                                @error('deviceId')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDeviceName" class="col-sm-3 col-form-label"><span class="fas fa-tag"></span> Nome dispositivo</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('deviceName') is-invalid @enderror" id="inputDeviceName" placeholder="Nome dispositivo" value="{{old('deviceName')??$device->name}}" name="deviceName">
                                @error('deviceName')
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
                                    <select class="form-control @error('gatewayName') is-invalid @enderror" name="gatewayName" id="inputgatewayName">
                                        <option @if($device->gateway=='US-Gateway') selected @endif >US-Gateway</option>
                                        <option @if($device->gateway=='DE-Gateway') selected @endif >DE-Gateway</option>
                                    </select>
                                    @error('gatewayName')
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
                                        <option @if($device->frequency=='0.5') selected @endif >0.5</option>
                                        <option @if($device->frequency=='1') selected @endif >1</option>
                                        <option @if($device->frequency=='1.5') selected @endif>1.5</option>
                                        <option @if($device->frequency=='2') selected @endif >2</option>
                                        <option @if($device->frequency=='2.5') selected @endif >2.5</option>
                                        <option @if($device->frequency=='3') selected @endif>3</option>
                                        <option @if($device->frequency=='3.5') selected @endif>3.5</option>
                                        <option @if($device->frequency=='4') selected @endif>4</option>
                                        <option @if($device->frequency=='4.5') selected @endif>4.5</option>
                                        <option @if($device->frequency=='5') selected @endif>5</option>
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
                <div id="cardDispositivo" class="card-body">
                    <p>Puoi creare un nuovo sensore inserendo le informazioni elencate in seguito:</p>
                    <form method="POST" action="#" id="sensorForm">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="inputSensorId" class="col-sm-3 col-form-label"><span class="fas fa-tag"></span> Id sensore</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('sensorId') is-invalid @enderror" id="inputSensorId" placeholder="Id sensore" value="" name="sensorId">
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
                                <input type="text" class="form-control @error('sensorType') is-invalid @enderror" id="inputSensorType" placeholder="Tipo di sensore" value="" name="sensorType">
                                @error('sensorType')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mx-1">
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
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('devices.index')}}" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-save"></span>
                        </span>
                <span class="text">Salva</span>
            </a>
        </div>
    </div>


@endsection
