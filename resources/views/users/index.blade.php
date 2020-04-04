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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTableUsers" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                            <th>Ruolo</th>
                            <th>Stato</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tfoot class="thead-dark table-borderless">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Email</th>
                            <th>Ruolo</th>
                            <th>Stato</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($users as $u)
                            <tr>
                                <td>{{$u->userId}}</td>
                                <td>{{$u->name}}</td>
                                <td>{{$u->surname}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->getRole()}}</td>
                                <td>
                                    @if($u->deleted)
                                        <span class="badge badge-danger">Disattivo</span>
                                    @else
                                        <span class="badge badge-success">Attivo</span>
                                    @endif
                                <td class="text-center">
                                    <a href="{{route('users.show', ['userId' => $u->userId ])}}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                        <span class="text">Dettagli</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @canany(['isAdmin', 'isMod'])
                                        @if($u->deleted)
                                            <a class="btn btn-success btn-icon-split" href="{{ route('users.restore', ['userId' => $u->userId ]) }}"
                                               onclick="event.preventDefault(); document.getElementById('restore-form-{{$u->userId}}').submit();">
                                            <span class="icon text-white-50">
                                              <span class="fas fa-user-check"></span>
                                            </span>
                                                <span class="text">Ripristina</span>
                                            </a>
                                            <form id="restore-form-{{$u->userId}}" action="{{ route('users.restore', ['userId' => $u->userId ]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        @else
                                            <a class="btn btn-danger btn-icon-split" href="{{ route('users.destroy', ['userId' => $u->userId ]) }}"
                                               onclick="event.preventDefault(); document.getElementById('delete-form-{{$u->userId}}').submit();">
                                            <span class="icon text-white-50">
                                              <span class="fas fa-user-times"></span>
                                            </span>
                                                <span class="text">Elimina</span>
                                            </a>
                                            <form id="delete-form-{{$u->userId}}" action="{{ route('users.destroy', ['userId' => $u->userId ]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
