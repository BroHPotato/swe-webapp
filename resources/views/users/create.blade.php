@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.create'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Creazione Utente</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('users.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        @canany(['isAdmin', 'isMod'])
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <span class="fas fa-user-edit"></span>
                    Modifica informazioni
                </h6>
            </div>
                <div class="card-body">
                    <p>Puoi modificare le informazioni dell'account cambiando i campi contenuti di seguito.</p>
                    <form method="POST" action="{{route('users.store')}}" id="create">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label"><span class="fas fa-user"></span> Nome</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" value="{{old('name')}}" name="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSurname" class="col-sm-4 col-form-label"><span class="fas fa-user"></span> Cognome</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" id="inputSurname" placeholder="Cognome" value="{{old('surname')}}" name="surname">
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        @can('isAdmin')
                            <div class="form-group row">
                                <label for="inputType" class="col-sm-4 col-form-label"><span class="fas fa-user-tag"></span> Ruolo</label>
                                <div class="col-sm-8">
                                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="inputType">
                                        <option value="0">Utente</option>
                                        <option value="1">Moderatore</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEnte" class="col-sm-4 col-form-label"><span class="fas fa-user-tag"></span> Ente</label>
                                <div class="col-sm-8">
                                    <select class="form-control @error('entityId') is-invalid @enderror" name="entityId" id="inputEnte">
                                        @foreach($entities as $entity)
                                            <option value="{{$entity->entityId}}">{{$entity->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('entityId')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-4 col-form-label"><span class="fas fa-envelope text-gray-500"></span> Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email" value="{{old('email')}}" name="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                @endcanany
            </div>
        </div>
            <div class="d-sm-flex mb-4 ml-sm-auto float-right">
                <button type="submit" form="create" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                      <span class="fas fa-plus-circle"></span>
                                    </span>
                    <span class="text">Aggiungi</span>
                </button>
            </div>
    </div>
@endsection
