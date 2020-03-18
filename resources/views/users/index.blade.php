@extends('layouts.app')




@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <div class="d-felx">
        <div class="col-3-auto p-3" style="max-width: 13rem">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Dispositivi disponibili</h5>
                    <p class="card-text"></p>
                    <a href="{{$user->id}}/devices" class="btn btn-primary">Vai ai dispositivi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
