@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('entities.show', $entity->entityId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Informazioni ente</h1>
        </div>
        <div class="row">
            <div class="col-auto mb-4 ">
                <a href="{{route('entities.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary"><span class="fas fa-building"></span>Informazioni ente</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-striped table-bordered border-secondary">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Nome</th>
                            <th>Luogo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>{{$entity->name}}</th>
                            <th>{{$entity->location}}</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <a href="#collapseAddView" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseAddView">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span class="fas fa-plus-square"></span>
                            Aggiungi sensore
                        </h6>
                    </a>
                    <div class="collapse" id="collapseAddView">
                        <div class="card-body">
                            <form method="POST" action="{{----}}">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <label for="inputSensor1" class="col-sm-3 col-form-label"><span class="fas fa-thermometer-half"></span> Sensore</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <select class="form-control @error('sensor') is-invalid @enderror" name="sensor" id="inputSensor">
                                                @foreach($devices as $d)
                                                   @foreach($sensors[$d->deviceId] as $s)
                                                        <option value="{{$s->sensorId}}">{{$d->name . ' - @' . $s->realSensorId}}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @error('sensor')
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
            <div class="col-xl-7 mb-4">
                <div class="card shadow">
                    <div class="card-header py3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-users"></span> Lista utenti</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-xl">
                            <table class="table table-striped table-bordered border-secondary">
                                <thead class="thead-dark table-borderless">
                                <tr>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->surname}}</td>
                                            <td>{{$user->email}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-thermometer-half"></span> Lista sensori</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-xl">
                            <table class="table table-striped table-bordered border-secondary">
                                <thead class="thead-dark table-borderless">
                                    <tr>
                                        <th>Id</th>
                                        <th>Tipo</th>
                                        <th>Dispositivo</th>
                                        <th>Invio comandi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sensorsEntity as $s)
                                        <tr>
                                            <td>{{$s->realSensorId}}</td>
                                            <td>{{$s->type}}</td>
                                            <td>{{$s->device}}</td>
                                            <td>{{($s->cmdEnabled) ? 'Abilitato' : 'Disabilitato'}}</td>
                                            <td>
                                                <span class="fas fa-trash text-danger delete"></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-sm-flex ml-sm-auto float-right">
                                <button type="submit" class="btn btn-success btn-icon-split" form="update">
                        <span class="icon text-white-50">
                          <span class="fas fa-save"></span>
                        </span>
                                    <span class="text">Salva</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

