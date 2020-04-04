@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('views'))
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Views </h1>
        </div>
        <div class="d-sm-flex mb-4 ml-sm-auto">
            <a href="{{route('dashboard.index')}}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <span class="fas fa-arrow-circle-left"></span>
                        </span>
                <span class="text">Torna indietro</span>
            </a>
        </div>
        <ul class="nav nav-tabs nav-tabs-icon-text auto">
            @foreach($views as $view)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('views.show', ['viewId' => $view->viewId])}}">
                    <span class="fas fa-chart-line">
                    </span> {{$view->name}}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <span class="fas fa-chart-line"></span>
                    Creazione view
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{--route('views.store')--}}">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="inputViewName" class="col-sm-4 col-form-label"><span class="fas fa-tag"></span> Nome view </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('viewName') is-invalid @enderror" id="inputViewName" placeholder="Nome" value="{{old('viewName')}}" name="viewName">
                            @error('viewName')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </form>
                <div class="d-sm-flex mb-4 ml-sm-auto">
                    <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <span class="fas fa-plus-circle"></span>
                            </span>
                        <span class="text">Aggiungi</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
