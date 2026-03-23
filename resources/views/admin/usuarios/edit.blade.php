@extends('layouts.app')

@section('content')
    <h1 style="font-size:22px;" class="mb-3">Editar Usuario</h1>



    <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.usuarios._form')

        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-primary btn-sm btn-nuevo">Actualizar</button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-sm btn-nuevo">
                Volver
            </a>

        </div>
    </form>

@endsection