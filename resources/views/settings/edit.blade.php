@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('settings'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800">Impostazioni account</h1>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user-edit"></i>
                            Modifica informazioni
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>Puoi modificare le informazioni del tuo account cambiando i campi contenuti di seguito.</p>
                        <form method="POST" action="{{route('settings.update')}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-4 col-form-label"><i class="fas fa-envelope text-gray-500"></i> Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email" value="{{$user->email}}" name="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputTg" class="col-sm-4 col-form-label"><i class="fab fa-telegram text-primary"></i> Username Telegram</label>
                                <div class="col-sm-8">
                                    <input type="username" class="form-control @error('telegramName') is-invalid @enderror" id="inputTg" placeholder="Username Telegram" value="{{$user->telegramName}}" name="telegramName">
                                    @error('telegramName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <i class="fas fa-shield-alt text-info"></i>
                                    Sicurezza account
                                </div>
                                <div class="col-sm-8">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="gridCheck" name="tfa" value="true" @if($user->tfa) checked @endif @if(!$user->telegramChat) disabled @endif>
                                        <label class="custom-control-label" for="gridCheck">
                                            <i>Autenticazione a due fattori con Telegram* </i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p class="my-2 small"><i class="fas fa-info-circle text-primary"></i>
                                *Per attivare l'<em>autenticazione a due fattori</em> è necessario inserire il proprio username Telegram
                                e avviare il bot direttamente dall'applicazione, inserendo il comando <code>/start</code> in chat.
                            </p>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
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
                            <i class="fas fa-user-lock"></i>
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
                                    <i class="fas fa-lock-open text-danger"></i> Password attuale</label>
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
                                    <i class="fas fa-lock text-success"></i> Nuova password</label>
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
                                    <i class="fas fa-redo-alt text-success"></i> Ripeti nuova password</label>
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
                            <button type="submit" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
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
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bell"></i> Notifiche alert</h6>
            </div>
            <!-- TODO implementare la paginazione in JS una volta realizzate le pagine sensori e dispositivi -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="35px"> </th>
                            <th>Status</th>
                            <th>Dispositivo</th>
                            <th>Sensore</th>
                            <th>Soglia</th>
                            <th>Valore</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th> </th>
                            <th>Status</th>
                            <th>Dispositivo</th>
                            <th>Sensore</th>
                            <th>Soglia</th>
                            <th>Valore</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" checked name="alerts[]" value="id_sensore_db"></td>
                            <td><span class="badge badge-success">Attivo</span></td>
                            <td>Disp1</td>
                            <td>Sens1</td>
                            <td>maggiore di</td>
                            <td>10</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
