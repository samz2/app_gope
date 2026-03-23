@extends('layouts.app')

@section('title', 'Nueva Empresa')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Nueva Empresa</h1>
    </div>

    <form method="POST" action="{{ route('empresas.store') }}">
        @csrf

        @include('empresas._form')

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button class="btn btn-success btn-sm">Guardar</button>
            <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>
    </form>

@endsection