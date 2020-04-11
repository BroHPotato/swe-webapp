@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('views.show', $view->viewId))
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$view->name}}</h1>
    </div>
    <div class="d-flex justify-content-between">
        <a href="{{route('views.index')}}" class="btn btn-sm btn-danger btn-icon-split mb-3 mr-4">
            <span class="icon text-white-50">
              <span class="fas fa-arrow-circle-left"></span>
            </span>
            <span class="text">Torna indietro</span>
        </a>
        <a class="btn btn-sm btn-danger btn-icon-split mb-3" href="{{ route('views.destroy', ['viewId'=>$view->viewId]) }}"
           onclick="event.preventDefault(); document.getElementById('destroy-view').submit();">
            <span class="icon text-white-50">
              <span class="fas fa-times"></span>
            </span>
            <span class="text">Elimina View</span>
        </a>
        <form id="destroy-view" action="{{ route('views.destroy', ['viewId'=>$view->viewId]) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <a href="#collapseAddView" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseAddView">
                    <h6 class="m-0 font-weight-bold text-success">
                        <span class="fas fa-plus-square"></span>
                        Aggiungi grafico pagina view
                    </h6>
                </a>
                <div class="collapse" id="collapseAddView">
                    <div class="card-body">
                        <form method="POST" action="{{route('graphs.store', ['viewId'=>$view->viewId])}}">
                            @csrf
                            @method('POST')
                            <div class="form-group row">
                                <label for="inputSensor1" class="col-sm-3 col-form-label"><span class="fas fa-thermometer-half"></span> Sensore 1</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-3">
                                        <select class="form-control @error('sensore1') is-invalid @enderror" name="sensor1" id="inputSensor1">
                                            @foreach($devices as $d)
                                                @foreach($sensors[$d->deviceId] as $s)
                                                    <option value="{{$s->sensorId}}">{{$d->name . ' - @' . $s->realSensorId}}</option>
                                                @endforeach
                                            @endforeach
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
                                        <select class="form-control @error('sensor2') is-invalid @enderror" name="sensor2" id="inputSensor2">
                                            @foreach($devices as $d)
                                                @foreach($sensors[$d->deviceId] as $s)
                                                    <option value="{{$s->sensorId}}">{{$d->name . ' - @' . $s->realSensorId}}</option>
                                                @endforeach
                                            @endforeach
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
                            <hr>
                            <button type="submit" class="btn btn-success btn-icon-split float-right mb-3">
                            <span class="icon text-white-50">
                              <span class="fas fa-plus-circle"></span>
                            </span>
                                <span class="text">Aggiungi</span>
                            </button>
                        </form>
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
                    <a class="text-danger" href="{{ route('graphs.destroy', ['viewGraphId'=>$graph->viewGraphId]) }}"
                       onclick="event.preventDefault(); document.getElementById('destroy{{$graph->viewGraphId}}').submit();">
                        <span class="fas fa-times mr-1"></span>Elimina
                    </a>
                    <form id="destroy{{$graph->viewGraphId}}" action="{{ route('graphs.destroy', ['viewGraphId'=>$graph->viewGraphId]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="card-body">
                    <double-chart
                        :sensor1='{{json_encode($sensorsOnGraphs[$graph->viewGraphId][0])}}'
                        :sensor2='{{json_encode($sensorsOnGraphs[$graph->viewGraphId][1])}}'
                        :variance = {{$graph->correlation}}
                    ></double-chart>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection