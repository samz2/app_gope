@extends('layouts.dashboard')

@section('content')
    <h1 class="h3 mb-3">Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <h1 class="mt-1 mb-3">{{ $empresas }}</h1>
                </div>
            </div>
        </div>

        <a href="{{ route('clientes.index') }}" class="text-decoration-none text-dark">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <h1 class="mt-1 mb-3">{{ $clientes }}</h1>
                    </div>
                </div>
            </div>
        </a>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reservas</h5>
                    <h1 class="mt-1 mb-3">0</h1>
                </div>
            </div>
        </div>
    </div>

@endsection