@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Codice TFA <i class="fab fa-telegram text-primary"></i> </h1>
                                    <p>Accedi a <strong>Telegram</strong> e inserisci il codice che ti è stato inviato.</p>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="code" type="text"
                                               class="form-control form-control-user form-codice-tfa @error('email') is-invalid @enderror"
                                               name="code" placeholder="Inserisci il codice">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Invia codice <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
