@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.edit', $user->userId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Modifica profilo</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('users.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-arrow-circle-left"></span>
                </span>
                <span class="text">Torna alla lista utenti</span>
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <span class="fas fa-user-edit"></span>
                    Modifica informazioni
                </h6>
            </div>
            <div class="card-body">
                @if($user->type<Auth::user()->type)
                    <p>Puoi modificare le informazioni dell'account cambiando i campi contenuti di seguito.</p>
                    <form method="POST" action="{{route('users.update', $user->userId)}}">
                    @csrf
                    @method('PUT')
                    @canany(['isAdmin', 'isMod'])
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label"><span class="fas fa-user"></span> Nome</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nome" value="{{old('name')??$user->name}}" name="name">
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
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" id="inputSurname" placeholder="Cognome" value="{{old('surname')??$user->surname}}" name="surname">
                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    @endcanany
                    @can('isAdmin')
                        <div class="form-group row">
                            <label for="inputType" class="col-sm-4 col-form-label"><span class="fas fa-user-tag"></span> Ruolo</label>
                            <div class="col-sm-8">
                                <select class="form-control @error('type') is-invalid @enderror" name="type" id="inputType">
                                    <option value="0" @if($user->getRole()=='Utente') selected @endif>Utente</option>
                                    <option value="1" @if($user->getRole()=='Moderatore') selected @endif>Moderatore</option>
                                </select>
                                @error('type')
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email" value="{{old('email')??$user->email}}" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @can('isAdmin')
                        <div class="form-group row">
                            <label for="inputTelegramName" class="col-sm-4 col-form-label"><span class="fab fa-telegram text-primary"></span> Nome Telegram</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('telegramName') is-invalid @enderror" id="inputTelegramName" placeholder="Nome Telegram" value="{{old('telegramName')??$user->telegramName}}" name="telegramName">
                                @error('telegramName')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <span class="fas fa-lock text-success"></span>
                                Reset Password
                            </div>
                            <div class="col-sm-8">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="inputPassword" name="password" value=true>
                                    <label class="custom-control-label" for="inputPassword">
                                        <i>La password verrà rigenerata in maniera automatica</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @canany(['isAdmin', 'isMod'])
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <span class="fas fa-user-times text-danger"></span>
                                Disattivazione
                            </div>
                            <div class="col-sm-8">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="deleteCheck" name="deleted" value=true @if($user->deleted || old('deleted')) checked @endif>
                                    <label class="custom-control-label" for="deleteCheck">
                                        <i>L'account non verra eliminato dal database</i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endcanany
                    @can('isAdmin')
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <span class="fas fa-shield-alt text-info"></span>
                                Sicurezza account
                            </div>
                            <div class="col-sm-8">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="gridCheck" name="tfa" value=true @if($user->tfa || old('tfa')) checked @endif>
                                    <label class="custom-control-label" for="gridCheck">
                                        <i>Autenticazione a due fattori con Telegram* </i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endcan
                        <hr>
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <span class="fas fa-edit"></span>
                        </span>
                        <span class="text">Modifica</span>
                    </button>
                </form>
                @else
                    <div class="alert alert-danger">Non puoi modificare un'utente con il tuo stesso ruolo!</div>
                @endif
            </div>
        </div>
    </div>
@endsection
