@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices.create'))
@section('content')
    <div class="d-sm-flex mb-4 ml-sm-auto">
        <a href="{{route('devices.index')}}" class="btn btn-danger btn-icon-split">
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
                Creazione dispositivo
            </h6>
        </div>
        @can(['isAdmin'])
            <div class="card-body">
                <p>Puoi creare un nuovo dispositivo inserendo le informazioni elencate in seguito:</p>
                <form method="POST" action="#">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="inputDeviceId" class="col-sm-4 col-form-label"><span class="fas fa-microchip"></span> Id dispositivo</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('deviceId') is-invalid @enderror" id="inputDeviceId" placeholder="Id dispositivo" value="" name="deviceid">
                            @error('deviceId')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDeviceName" class="col-sm-4 col-form-label"><span class="fas fa-tag"></span> Nome dispositivo</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('deviceName') is-invalid @enderror" id="inputDeviceName" placeholder="Nome dispositivo" value="" name="deviceName">
                            @error('deviceName')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputGatewayName" class="col-sm-4 col-form-label"><span class="fas fa-dungeon"></span> Nome gateway</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('gatewayName') is-invalid @enderror" id="inputGatewayName" placeholder="Nome gateway" value="" name="gatewayName">
                            @error('gatewayName')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="inputFrequency" class="col-sm-4 col-form-label"><span class="fas fa-history"></span> Frequenza ricezione dati</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                <select class="form-control @error('frequency') is-invalid @enderror" name="frequency" id="inputFrequency">
                                    <option >0.5</option>
                                    <option >1</option>
                                    <option >1.5</option>
                                    <option >2</option>
                                    <option >2.5</option>
                                    <option >3</option>
                                    <option >3.5</option>
                                    <option >4</option>
                                    <option >4.5</option>
                                    <option >5</option>
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
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-plus-circle"></i>
                                </span>
                                <span class="text">Aggiungi</span>
                            </button>
                        </div>
                    </div>
                </form>
                @endcan
            </div>
    </div>
@endsection
