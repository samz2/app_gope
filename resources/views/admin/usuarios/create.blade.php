@extends('layouts.app')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Nuevo Usuario</h1>
    </div>

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        @include('admin.usuarios._form')

        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-success btn-sm btn-nuevo">
                Guardar
            </button>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-nuevo btn-sm">
                Volver
            </a>
        </div>
    </form>

@endsection