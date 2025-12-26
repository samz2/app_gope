@extends('layouts.dashboard')

@section('content')
    <h1>Nuevo Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        @include('clientes._form')

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@endsection