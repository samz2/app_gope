@extends('layouts.app')

@section('content')
    <h1 style="font-size:22px;" class="mb-3">Editar Usuario</h1>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.usuarios._form')

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-danger btn-sm btn-nuevo">
                        Cancelar
                    </a>
                    <button class="btn btn-primary btn-sm btn-nuevo">Actualizar</button>

                </div>
            </form>

        </div>
    </div>
@endsection