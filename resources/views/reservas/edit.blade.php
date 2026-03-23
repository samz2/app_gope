@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Editar Reserva</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('reservas.update', $reserva) }}" method="POST">
                @csrf
                @method('PUT')

                @include('reservas._form')

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('reservas.index') }}" class="btn btn-outline-danger btn-sm btn-nuevo">
                        Cancelar
                    </a>

                    <button class="btn btn-success btn-sm btn-nuevo">
                        Actualizar Reserva
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection