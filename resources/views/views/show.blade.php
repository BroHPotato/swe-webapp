@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('views.show', $view->viewId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> View {{$view->name}} </h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <button class="btn-danger btn" onclick="window.history.back()">Torna indietro</button>
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
                    <span class="fas fa-chart-line"></span>
                    Creazione grafico
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{--route('views.store')--}}">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="inputSensor1" class="col-sm-3 col-form-label"><span class="fas fa-microchip"></span> Sensore 1</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <select class="form-control @error('sensore1') is-invalid @enderror" name="sensor1" id="inputSensor1">
                                    <option >0.5</option>   {{-- Lista con tutti i sensori--}}
                                </select>
                                @error('sensor1')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSensor12" class="col-sm-3 col-form-label"><span class="fas fa-microchip"></span> Sensore 2</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <select class="form-control @error('sensore2') is-invalid @enderror" name="sensor2" id="inputSensor2">
                                    <option >0.5</option>   {{-- Lista con tutti i sensori--}}
                                </select>
                                @error('sensor2')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSensor12" class="col-sm-3 col-form-label"><span class="fas fa-microchip"></span> Sensore 2</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <select class="form-control @error('sensore2') is-invalid @enderror" name="sensor2" id="inputSensor2">
                                    <option >0.5</option>   {{-- Lista con tutti i sensori--}}
                                </select>
                                @error('sensor2')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCorrelation" class="col-sm-3 col-form-label"><span class="fas fa-project-diagram"></span> Correlazione</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-3">
                                <select class="form-control @error('correlation') is-invalid @enderror" name="correlation" id="inputCorrelation">
                                    <option value="" selected="selected" disabled="disabled" hidden="hidden">Choose here</option>
                                    <option value="1">Covarianza</option>
                                    <option value="2">Correlazione di Pearson</option>
                                    <option value="3">Correlazione di Spearman</option>
                                </select>
                                @error('correlation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-sm-flex mb-4 ml-sm-auto">
                    <button type="submit" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                      <span class="fas fa-plus-circle"></span>
                                    </span>
                        <span class="text">Aggiungi</span>
                    </button>
                </div>
            </div>
        </div>

        @foreach($graphs as $graph)
            <div class="col-lg-2 col-md-3 col-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-chart-area"></span> Dati real-time</h6>
                    </div>
                    <div class="card-body">
                        <chart-management
                            v-bind:deviceId='{{$view->deviceId }}'
                            v-bind:sensorId1='{{$graph->sensorId1}}'
                            v-bind:sensorId2='{{$graph->sensorId2}}'
                        ></chart-management>
                    </div>
                    <div class="d-sm-inline-flex mb-4 ml-sm-auto float-right">
                        <button class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-trash"></span>
                                        </span>
                            <span class="text">Elimina</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
