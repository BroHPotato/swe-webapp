@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('devices.create'))
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-edit"></i>
                Modifica informazioni
            </h6>
        </div>
        @can(['isAdmin'])
            <div class="card-body">
                <p>Puoi creare un nuovo dispositivo inserendo le informazioni elencate in seguito:</p>
                <form method="POST" action="{{  }}">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="inputDeviceId" class="col-sm-4 col-form-label"><i class="fas fa-user"></i> Id dispositivo</label>
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
                        <label for="inputDeviceName" class="col-sm-4 col-form-label"><i class="fas fa-user"></i> Nome dispositivo</label>
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
                        <label for="inputFrequency" class="col-sm-4 col-form-label"><i class="fas fa-user-tag"></i> Frequenza ricezione dati</label>
                        <div class="col-sm-8">
                            <select class="form-control @error('frequency') is-invalid @enderror" name="frequency" id="inputFrequency">
                                <option value="0">0.5</option>
                                <option value="1">1</option>
                                <option value="2">1.5</option>
                                <option value="3">2</option>
                                <option value="4">2.5</option>
                                <option value="5">3</option>
                                <option value="6">3.5</option>
                                <option value="7">4</option>
                            </select>
                            @error('frequency')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
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
                            <button type="reset" class="btn btn-warning btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-undo-alt"></i>
                                </span>
                                <span class="text">Reset</span>
                            </button>
                            <a href="{{  }}" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-times"></i>
                                </span>
                                <span class="text">Annulla</span>
                            </a>
                        </div>
                    </div>
                </form>
                @endcan
            </div>
    </div>
@endsection
