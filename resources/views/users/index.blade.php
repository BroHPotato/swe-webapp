@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.index'))
@section('content')
    <div class="container-fluid">
            <div class="d-sm-flex mb-4">
                <h1 class="h3 mb-0 text-gray-800"> Gestione utenti</h1>
            </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('dashboard.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        @canany(['isAdmin', 'isMod'])
            <div class="d-sm-flex mb-4 ml-sm-auto">
                <a href="{{route('users.create')}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                      <span class="fas fa-user-plus"></span>
                    </span>
                    <span class="text">Aggiungi</span>
                </a>
            </div>
        @endcanany

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-users-cog"></span> Lista utenti</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table border-secondary table-bordered table-striped dataTableUsers">
                        <thead class="thead-dark table-borderless">
                            <tr>
                                <th>ID</th>
                                <th>Nome e cognome</th>
                                <th>Email</th>
                                <th>Ruolo</th>
                                <th>Stato</th>
                                <th class="bg-secondary"> </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $u)
                            <tr>
                                <td><a href="{{route('users.show', ['userId' => $u->userId ])}}">{{$u->userId}}</a></td>
                                <td><a href="{{route('users.show', ['userId' => $u->userId ])}}">{{$u->name}} {{$u->surname}}</a></td>
                                <td>{{$u->getRole()}}</td>
                                <td>{{$u->email}}</td>
                                <td>
                                    @if($u->deleted)
                                        <span class="badge badge-danger">Disattivo</span>
                                    @else
                                        <span class="badge badge-success">Attivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @canany(['isAdmin', 'isMod'])
                                    @if($user->type < Auth::user()->type)
                                        <div class="d-sm-flex mb-4 ml-sm-auto">
                                            <a href="{{route('users.edit', $user->userId)}}" class="btn btn-small btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                  <span class="fas fa-user-edit"></span>
                                                </span>
                                                <span class="text">Modifica</span>
                                            </a>
                                        </div>
                                    @endif
                                    @endcanany
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
