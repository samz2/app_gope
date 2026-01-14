@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="font-size:22px;">Nuevo Cliente</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            @include('clientes._form')

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-danger btn-sm btn-nuevo">
                    Cancelar
                </a>
                <button class="btn btn-success btn-sm btn-nuevo">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('clientes._scripts')
@endpush
