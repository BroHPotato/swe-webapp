@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('views.show', $view->viewId))
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$view->name}}</h1>
    </div>
    <a href="{{route('views.index')}}" class="btn btn-sm btn-danger btn-icon-split mb-3">
        <span class="icon text-white-50">
          <span class="fas fa-arrow-circle-left"></span>
        </span>
        <span class="text">Torna indietro</span>
    </a>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <a href="#collapseAddView" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseAddView">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <span class="fas fa-plus-square"></span>
                        Aggiungi grafico pagina view
                    </h6>
                </a>
                <div class="collapse show" id="collapseAddView"> <!-- TODO rimuovere show una volta implementato il backend -->
                    <div class="card-body">
                        <form method="POST" action="{{--route('views.store')--}}">
                            @csrf
                            @method('POST')
                            <div class="form-group row">
                                <label for="inputSensor1" class="col-sm-3 col-form-label"><span class="fas fa-thermometer-half"></span> Sensore 1</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select class="form-control @error('sensore1') is-invalid @enderror" name="sensor1" id="inputSensor1">
                                            <option value="id">Nome dispositivo - Nome sensore</option>  {{-- Lista con tutti i dispositivi dell'ente o di tutti quelli disponibili per l'admin --}}
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
                                <label for="inputSensor12" class="col-sm-3 col-form-label"><span class="fas fa-thermometer-three-quarters"></span> Sensore 2</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select class="form-control @error('sensore2') is-invalid @enderror" name="sensor2" id="inputSensor2">
                                            <option value="id">Nome dispositivo - Nome sensore</option>  {{-- Lista con tutti i dispositivi dell'ente o di tutti quelli disponibili per l'admin --}}
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
                                            <option value="0" selected>Nessuna</option>
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
            </div>
        </div>
    </div>

    <div class="row">
    @foreach($graphs as $graph)
        <div class="col-lg-6 col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-chart-area"></span> Dati real-time
                        </h6>
                    <a href="#link-bello-per-cancellare-singola-view" class="text-danger">
                        <span class="fas fa-times mr-1"></span>Elimina
                    </a>
                </div>
                <div class="card-body">
                        <double-chart
                            :sensor1='{{json_encode($sensor1)}}'
                            :sensor2='{{json_encode($sensor2)}}'
                            :variance = {{$graph->correlation}}
                        ></double-chart>
                
                    <!-- <chart-management
                        v-bind:deviceId='{{$view->deviceId }}'
                        v-bind:sensorId1='{{$graph->sensorId1}}'
                        v-bind:sensorId2='{{$graph->sensorId2}}'
                    ></chart-management> -->
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
