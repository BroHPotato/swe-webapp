@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('alerts'))
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Alerts</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-bell"></span> Lista alerts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <form action="{{route('settings.updateAlerts')}}" method="POST">
                            @csrf
                            @method('POST')
                            <table class="table table-bordered table-striped border-secondary">
                                <thead class="thead-dark table-borderless">
                                <tr>
                                    <th class="text-center"><span class="fas fa-list-ul"></span></th>
                                    <th>Dispositivo</th>
                                    <th>Sensore</th>
                                    <th>Soglia</th>
                                    <th>Valore</th>
                                    <th>Ultimo invio</th>
                                    @canany(['isMod', 'isAdmin'])
                                        <th class="bg-secondary"> </th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alertsWithSensors as $status => $a)
                                    @foreach($a as $list)
                                        <tr>
                                            <td><span class="logic-id">{{$list['alert']->alertId}}</span></td>
                                            <td><a href="{{route('devices.show', ['deviceId' => $list['device']->deviceId])}}">{{$list['device']->name}}</a></td>
                                            <td><a href="{{route('sensors.show', ['deviceId' => $list['device']->deviceId, 'sensorId' => $list['sensor']->realSensorId])}}"><span class="real-id">{{$list['sensor']->realSensorId}}</span></td>
                                            <td>{{$list['alert']->getType()}}</td>
                                            <td>{{$list['alert']->threshold}}</td>
                                            <td>{{$list['alert']->lastSent??'-'}}</td>
                                            @canany(['isMod', 'isAdmin'])
                                            <td>
                                                <a href="{{route('alerts.edit', $list['alert']->alertId)}}" class="btn btn-sm btn-warning btn-icon-split">
                                                    <span class="icon text-white-50">
                                                      <span class="fas fa-edit"></span>
                                                    </span>
                                                    <span class="text">Modifica</span>
                                                </a>
                                            </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
