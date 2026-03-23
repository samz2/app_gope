@extends('layouts.app')

@section('title', 'Editar Cliente')
@php
    $locked = session()->has('client_updated');
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Editar Cliente</h1>
    </div>


    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        @include('clientes._form')


        <button class="btn btn-primary btn-sm btn-nuevo">
            Actualizar
        </button>
        <div class="d-flex justify-content-end gap-2 mt-3">

            <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm btn-nuevo">
                Volver
            </a>

        </div>
    </form>

@endsection

@push('modals')
    @if(session('client_updated'))
        <x-modal-success title="Cliente" message="{{ session('client_message') }}" :redirectOk="route('clientes.index')"
            :redirectCancel="route('clientes.edit', $cliente->id)" delay="3500" />
    @endif
@endpush