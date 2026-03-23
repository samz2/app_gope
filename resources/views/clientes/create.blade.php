@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Nuevo Cliente</h1>
    </div>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        @include('clientes._form')

        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-success btn-sm btn-nuevo">
                Guardar
            </button>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm btn-nuevo">
                Volver
            </a>
        </div>
    </form>

@endsection

@push('scripts')
    @include('clientes._scripts')
@endpush