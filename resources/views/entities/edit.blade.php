@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('entities.edit', $entity->name))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Modifica ente</h1>
        </div>
        <div class="d-sm-inline-flex mb-4 ml-sm-auto">
            <a href="{{route('entities.index')}}" class="btn btn-danger btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-arrow-circle-left"></span>
                </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        @can(['isAdmin'])
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                   <span class="icon text-blue-50">
                          <span class="fas fa-plus-circle"></span>
                   </span>
                    Modifica ente
                </h6>
            </div>
                <div id="cardGateway" class="card-body">
                    <p>Puoi creare un nuovo ente inserendo le informazioni elencate in seguito:</p>
                    <form method="POST" action="{{--route('entities.store')--}}">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="inputEntityName" class="col-sm-4 col-form-label"><span class="fas fa-building"></span> Nome ente</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('entityName') is-invalid @enderror" id="inputEntityName" placeholder="Nome dell'ente" value="{{old('entityName')??$entity->name}}" name="entityName">
                                @error('entityName')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEntityLocation" class="col-sm-4 col-form-label"><span class="fas fa-location-arrow"></span> Luogo </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('entityLocation') is-invalid @enderror" id="inputEntityLocation" placeholder="Sede dell'ente" value="{{old('entityLocation')??$entity->location}}" name="entityLocation">
                                @error('entityLocation')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
        </div>
        <div class="d-inline-block my-1 px-0">
            <a href="#" id="addGateway" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-save"></span>
                </span>
                <span class="text">Salva</span>
            </a>
        </div>
            <div class="d-inline-block my-1 px-0 float-right">
                <button class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <span class="fas fa-trash"></span>
                            </span>
                    <span class="text">Elimina</span>
                </button>
            </div>
        @endcan
    </div>


@endsection

