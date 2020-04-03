@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.edit', $user->userId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Modifica profilo</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('users.index')}}" class="btn btn-danger btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-arrow-circle-left"></span>
                </span>
                <span class="text">Torna indietro</span>
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
                            <label for="inputTelegramChat" class="col-sm-4 col-form-label"><span class="fas fa-comment-dots text-primary"></span> Chat Telegram</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('telegramChat') is-invalid @enderror" id="inputTelegramChat" placeholder="Chat Telegram" value="{{old('telegramChat')??$user->telegramChat}}" name="telegramChat">
                                @error('telegramChat')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4 col-form-label"><span class="fas fa-lock text-success"></span> Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" placeholder="Password" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                                        <i>L'account non verra eliminato dal database</span>
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
                                        <i>Autenticazione a due fattori con Telegram* </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="my-2 small"><span class="fas fa-info-circle text-primary"></span>
                            *Per attivare l'<em>autenticazione a due fattori</em> è necessario inserire lo username Telegram
                            e avviare il bot direttamente dall'applicazione, inserendo il comando <code>/start</code> in chat.
                        </p>
                    @endcan
                </form>
                @else
                    <p>Non puoi modificare un'utente con il tuo stesso ruolo!</p>
                @endif
            </div>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <button type="submit" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <span class="fas fa-edit"></span>
                </span>
                <span class="text">Modifica</span>
            </button>
        </div>
    </div>
@endsection
