@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.create'))
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-edit"></i>
                Modifica informazioni
            </h6>
        </div>
        @canany(['isAdmin', 'isMod'])
            <div class="card-body">
                <p>Puoi modificare le informazioni dell'account cambiando i campi contenuti di seguito.</p>
                <form method="POST" action="{{route('users.store')}}">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"><i class="fas fa-user"></i> Nome</label>
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
                        <label for="inputSurname" class="col-sm-4 col-form-label"><i class="fas fa-user"></i> Cognome</label>
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
                            <label for="inputType" class="col-sm-4 col-form-label"><i class="fas fa-user-tag"></i> Ruolo</label>
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
                            <label for="inputEnte" class="col-sm-4 col-form-label"><i class="fas fa-user-tag"></i> Ente</label>
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
                        <label for="inputEmail" class="col-sm-4 col-form-label"><i class="fas fa-envelope text-gray-500"></i> Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email" value="{{old('email')}}" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword check" class="col-sm-4 col-form-label"><i class="fas fa-lock-open text-danger"></i> Inserisci la tua password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control @error('password_check') is-invalid @enderror" id="inputPassword_check" placeholder="Password" value="" name="password_check">
                            @error('password_check')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
                            <a href="{{route('users.store')}}" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-times"></i>
                                </span>
                                <span class="text">Annulla</span>
                            </a>
                        </div>
                    </div>
                </form>
            @endcanany
        </div>
    </div>
@endsection
