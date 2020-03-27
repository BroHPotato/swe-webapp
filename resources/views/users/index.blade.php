@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('users.index'))
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="d-sm-flex mb-4">
                <h1 class="h3 mb-0 text-gray-800"> Gestione utenti</h1>
            </div>
            <div class="d-sm-flex mb-4 ml-sm-auto">
                <a href="{{route('users.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-user-plus"></i>
                </span>
                    <span class="text">Aggiungi</span>
                </a>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users-cog"></i> Lista utenti</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
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
                        <tfoot>
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
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->userId}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->getRole()}}</td>
                                <td>
                                    @if($user->deleted)
                                        <span class="badge badge-danger">Disattivo</span>
                                    @else
                                        <span class="badge badge-success">Attivo</span>
                                    @endif
                                <td><a href="{{route('users.show', ['userId' => $user->userId ])}}" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                              <i class="fas fa-info-circle"></i>
                                            </span>
                                        <span class="text">Dettagli</span>
                                    </a>
                                </td>
                                <td>
                                    @if($user->deleted)
                                        <a class="btn btn-success btn-icon-split" href="{{ route('users.restore', ['userId' => $user->userId ]) }}"
                                           onclick="event.preventDefault(); document.getElementById('restore-form').submit();">
                                            <span class="icon text-white-50">
                                              <i class="fas fa-user-check"></i>
                                            </span>
                                            <span class="text">Ripristina</span>
                                        </a>
                                        <form id="restore-form" action="{{ route('users.restore', ['userId' => $user->userId ]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    @else
                                        <a class="btn btn-danger btn-icon-split" href="{{ route('users.destroy', ['userId' => $user->userId ]) }}"
                                           onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                                            <span class="icon text-white-50">
                                              <i class="fas fa-user-times"></i>
                                            </span>
                                            <span class="text">Elimina</span>
                                        </a>
                                        <form id="delete-form" action="{{ route('users.destroy', ['userId' => $user->userId ]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif



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
