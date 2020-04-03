@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.show', $user->userId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Profilo</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('users.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        @if($user->type<Auth::user()->type)
            <div class="d-sm-flex mb-4 ml-sm-auto">
                <a href="{{route('users.edit', $user->userId)}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <span class="fas fa-user-plus"></span>
                </span>
                    <span class="text">Modifica</span>
                </a>
            </div>
        @endif
        <div class="row mx-auto">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span class="fas fa-info"></span>
                            Dettagli
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-bold"><span class="fas fa-hashtag"></span> ID : <span class="font-weight-normal">{{$user->userId}}</span></p>
                        <p class="font-weight-bold"><span class="fas fa-user"></span> Nome e cognome : <span class="font-weight-normal">{{$user->name . ' ' . $user->surname}}</span></p>
                        <p class="font-weight-bold"><span class="fas fa-user-tag"></span> Ruolo : <span class="font-weight-normal">{{$user->getRole()}}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <span class="fas fa-address-book"></span>
                                Contatti
                            </h6>
                        </div>
                    <div class="card-body">
                            <p class="font-weight-bold"><span class="fas fa-envelope text-gray-500"></span> Email : <span class="font-weight-normal">{{$user->email}}</span></p>
                            <p class="font-weight-bold"><span class="fab fa-telegram text-primary"></span> Username Telegram : <span class="font-weight-normal">{{$user->telegramName?? 'NA'}}</span></p>
                            <p class="font-weight-bold"><span class="fas fa-comment-dots text-primary"></span> Chat Telegram : <span class="font-weight-normal">{{$user->telegramChat?? 'NA'}}</span></p>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span class="fas fa-lock"></span>
                            Sicurezza
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-bold"><span class="fas fa-shield-alt text-info"></span> Sicurezza account :
                            @if($user->tfa)
                                <span class="badge badge-success">Attivo</span>
                            @else
                                <span class="badge badge-danger">Disattivo</span>
                            @endif</p>
                        <p class="font-weight-bold"><span class="fas fa-user-lock"></span> Stato :
                            @if($user->deleted)
                                <span class="badge badge-danger">Disattivo</span>
                            @else
                                <span class="badge badge-success">Attivo</span>
                            @endif </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
