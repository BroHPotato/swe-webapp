@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('alerts'))
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Modifica alerts</h1>
    </div>
    <div class="d-flex justify-content-between">
            <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
            <span class="icon text-white-50">
              <span class="fas fa-arrow-circle-left"></span>
            </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-bell"></span> Modifica alerts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <form action="{{route('settings.updateAlerts')}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="inputSensore" class="col-sm-3 col-form-label"><span class="fas fa-temperature-high"></span> Sensore</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select class="form-control @error('sensor') is-invalid @enderror" name="sensorId" id="inputSensor">
                                            <option value="idlogicosensore">Nome dispositivo - id reale sensore (vedi pagina view)</option>
                                        </select>
                                        @error('sensor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputSoglia" class="col-sm-3 col-form-label"><span class="fas fa-radiation"></span> Soglia</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select class="form-control @error('sensor') is-invalid @enderror" name="threshold" id="inputSoglia">
                                            <option value="tiponumerosoglia">maggiore di o minore di o uguale a</option>
                                        </select>
                                        @error('sensor')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputValue" class="col-sm-3 col-form-label"><span class="fas fa-radiation-alt"></span> Valore di soglia</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control @error('sensor') is-invalid @enderror" name="thresholdvalue" id="inputValue"
                                               placeholder="Inserisci un valore di soglia" value="valorenumerico">
                                        @error('sensor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
