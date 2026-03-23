@extends('layouts.app')

@section('title', 'Nueva Cancha')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Nueva Cancha</h1>
    </div>

    <form method="POST" action="{{ route('canchas.store') }}" enctype="multipart/form-data">
        @csrf
        @include('canchas._form')

        {{-- Botones --}}
        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-success btn-sm btn-nuevo">
                Guardar
            </button>
            <a href="{{ route('canchas.index') }}" class="btn btn-success btn-sm btn-nuevo">
                Volver
            </a>
        </div>

    </form>
@endsection