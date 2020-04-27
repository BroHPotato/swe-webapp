@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('gateways.index'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Gateway </h1>
        </div>
        @include('layouts.error')
        <div class="row">
            <div class="col-auto mb-4">
                <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                              <span class="fas fa-arrow-circle-left"></span>
                            </span>
                    <span class="text">Torna indietro</span>
                </a>
            </div>
            @can(['isAdmin'])
                <div class="col-auto mb-4">
                    <a href="{{route('gateways.create')}}" class="btn btn-sm btn-success btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-plus-circle"></span>
                        </span>
                        <span class="text">Aggiungi gateway</span>
                    </a>
                </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-dungeon"></span> Lista gateway</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive-xl">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>ID </th>
                            <th>Nome</th>
                            <th>Numero Dispositivi</th>
                            <th> </th>
                            <th> </th>
                            <th>Configurazione</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gatewaysWithDevices as $gWd)
                            <tr>
                                <td>{{$gWd['gateway']->gatewayId}}</td>
                                <td><span class="text-gray-800">{{substr($gWd['gateway']->name, 0, 3)}}</span>{{substr($gWd['gateway']->name, 3)}}</td>
                                <td>{{count($gWd['devices'])}}</td>
                                <td class="text-center"><a href="{{route('gateways.show', [
                                                    'gatewayId' => $gWd['gateway']->gatewayId
                                            ])}}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-info-circle"></span>
                                        </span>
                                        <span class="text">Dettagli</span>
                                    </a>
                                </td>
                                <td class="text-center"><a href="{{route('gateways.edit', ['gatewayId' => $gWd['gateway']->gatewayId ])}}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                          <span class="fas fa-edit"></span>
                                        </span>
                                        <span class="text">Modifica</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a onclick="event.preventDefault(); document.getElementById('config').submit();" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                      <span class="fas fa-paper-plane"></span>
                                    </span>
                                        <span class="text">Invia</span>
                                    </a>
                                    <form id="config" action="{{ route('gateways.config', ['gatewayId' => $gWd['gateway']->gatewayId]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan
    </div>
@endsection
