@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('settings'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800">Impostazioni account</h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('dashboard.index')}}" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span class="fas fa-user-edit"></span>
                            Modifica informazioni
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>Puoi modificare le informazioni del tuo account cambiando i campi contenuti di seguito.</p>
                        <form method="POST" action="{{route('settings.update')}}">
                            @csrf
                            @method('PUT')
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
                            <div class="form-group row">
                                <label for="inputTg" class="col-sm-4 col-form-label"><span class="fab fa-telegram text-primary"></span> Username Telegram</label>
                                <div class="col-sm-8">
                                    <input type="username" class="form-control @error('telegramName') is-invalid @enderror" id="inputTg" placeholder="Username Telegram" value="{{old('telegramName')??$user->telegramName}}" name="telegramName">
                                    @error('telegramName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <span class="fas fa-shield-alt text-info"></span>
                                    Sicurezza account
                                </div>
                                <div class="col-sm-8">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="gridCheck" name="tfa" value="true" @if($user->tfa || old('tfa')) checked @endif @if(!$user->telegramChat) disabled @endif>
                                        <label class="custom-control-label" for="gridCheck">
                                            <span>Autenticazione a due fattori con Telegram* </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p class="my-2 small"><span class="fas fa-info-circle text-primary"></span>
                                *Per attivare l'<em>autenticazione a due fattori</em> è necessario inserire il proprio username Telegram
                                e avviare il bot direttamente dall'applicazione, inserendo il comando <code>/start</code> in chat.
                            </p>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-icon-split float-right">
                                <span class="icon text-white-50">
                                  <span class="fas fa-edit"></span>
                                </span>
                                <span class="text">Modifica</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <span class="fas fa-user-lock"></span>
                            Modifica password
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>Per modificare la password del tuo account, compila tutti i campi di seguito.</p>
                        <form method="POST" action="{{route('settings.update')}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="inputPA" class="col-sm-4 col-form-label">
                                    <span class="fas fa-lock-open text-danger"></span> Password attuale</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPA"
                                           placeholder="Password attuale" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPN" class="col-sm-4 col-form-label">
                                    <span class="fas fa-lock text-success"></span> Nuova password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="inputPN"
                                           placeholder="Nuova password" name="new password">
                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPNR" class="col-sm-4 col-form-label">
                                    <span class="fas fa-redo-alt text-success"></span> Ripeti nuova password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="inputPNR"
                                           placeholder="Ripeti nuova password" name="confirm password">
                                    @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr class="mt-4">
                            <button type="submit" class="btn btn-primary btn-icon-split float-right">
                                <span class="icon text-white-50">
                                  <span class="fas fa-edit"></span>
                                </span>
                                <span class="text">Modifica</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-bell"></span> Notifiche alert</h6>
            </div>
            <div class="card-body">
                @canany(['isUser', 'isMod'])
                    <div class="table-responsive-sm">
                        <form action="{{route('settings.updateAlerts')}}" method="POST">
                            @csrf
                            @method('POST')
                            <table class="table table-bordered table-striped border-secondary">
                                <thead class="thead-dark table-borderless">
                                    <tr>
                                        <th width="1em" class="bg-secondary"><span class="far fa-bell"></span></th>
                                        <th>Dispositivo</th>
                                        <th>Sensore</th>
                                        <th>Soglia</th>
                                        <th>Valore</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alertsWithSensors as $status => $a)
                                        @foreach($a as $list)
                                            <tr>
                                                <td><input type="checkbox" @if($status == "enable") checked @endif name="alerts[]" value="{{$list['alert']->alertId}}"></td>
                                                <td>{{$list['device']->name}}</td>
                                                <td><span class="real-id">{{$list['alert']->sensor}}</span></td>
                                                <td>{{$list['alert']->getType()}}</td>
                                                <td>{{$list['alert']->threshold}}</td>
                                                @if($status == "enable")
                                                    <td><span class="badge badge-success">Attivo</span></td>
                                                @else
                                                    <td><span class="badge badge-danger">Disattivo</span></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                            </tbody>
                            </table>
                            <button type="submit" class="btn btn-sm btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                      <span class="fas fa-check-circle"></span>
                                </span>
                                <span class="text">Salva</span>
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
