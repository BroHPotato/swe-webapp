@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('logs'))
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Logs</h1>
    </div>
    <div class="row">
        <div class="col-auto mb-4 ">
            <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                <span class="icon text-white-50">
                  <span class="fas fa-arrow-circle-left"></span>
                </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-history"></span> Lista Logs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table class="table table-striped table-bordered border-secondary">
                            <thead class="thead-dark table-borderless">
                            <tr>
                                <th>Data ora</th>
                                <th>Nome e cognome</th>
                                <th>Rango</th>
                                <th>Azione</th>
                                <th>IP</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="small">10 aprile 2015 - ore 26:00</td>
                                    <td>massimo</td>
                                    <td>aDmIn</td>
                                    <td class="small"><code>faccio cose ciao</code></td>
                                    <td><code> il mio ip </code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
