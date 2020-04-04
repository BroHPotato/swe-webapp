@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('gateways.show', $gateway->gatewayId))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Informazioni Gateway</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <button class="btn-danger btn" onclick="window.history.back()">Torna indietro</button>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary"><span class="fas fa-microchip"></span> Informazioni Gateway</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Numero di dispositivi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$gateway->gatewayId}}</td>
                            <td>{{$gateway->name}}</td>
                            <td>3</td> {{--NUMERO DI DISPOSITIVI DA PRENDERE DINAMICAMENTE--}}
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-thermometer-half"></span> Lista dispositivi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark table-borderless">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Numero di sensori</th>
                        </tr>
                        </thead>
                        <tfoot class="thead-dark table-borderless">
                        <tr>
                            <<th>Id</th>
                            <th>Nome</th>
                            <th>Numero di sensori</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Termostato</td>
                            <td>3</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
