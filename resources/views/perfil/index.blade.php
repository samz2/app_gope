@extends('layouts.app')
@php
    $locked = session()->has('profile_updated');
@endphp

@section('title', 'Mi Perfil')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Mi perfil</h5>

<form method="POST" action="{{ route('perfil.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $user->name) }}"
            {{ $locked ? 'disabled' : '' }}
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $user->email) }}"
            {{ $locked ? 'disabled' : '' }}
        >
    </div>
    {{-- CONTRASEÑA (solo si no está bloqueado) --}}
@unless($locked)
    <hr>

    <div class="mb-3">
        <label class="form-label">Nueva contraseña</label>
        <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Dejar vacío si no desea cambiarla"
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Confirmar contraseña</label>
        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            placeholder="Confirmar nueva contraseña"
        >
    </div>
@endunless

    @unless($locked)
        <button class="btn btn-outline-primary btn-nuevo">
            Actualizar datos
        </button>
    @endunless
</form>

    </div>
</div>
@endsection

@if(session('profile_updated'))
    <x-modal-success
        id="perfilSuccess"
        title="Mi perfil"
        message="¡Datos actualizados correctamente!"
        :okRoute="route('dashboard')"
        :cancelRoute="route('perfil.index')"
    />
@endif

