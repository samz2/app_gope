@extends('layouts.app')

@section('title', 'Editar Cancha')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Editar Cancha</h1>
    </div>

    <form method="POST" action="{{ route('canchas.update', $cancha) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('canchas._form', ['cancha' => $cancha])


        {{-- Botones (idénticos a clientes) --}}
        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-success btn-sm btn-nuevo">
                Actualizar
            </button>
            <a href="{{ route('canchas.index') }}" class="btn btn-success btn-sm btn-nuevo">
                Volver
            </a>
        </div>

    </form>
    </div>
    </div>
@endsection

<form id="deleteImageForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
    <script>
        document.querySelectorAll('.btn-delete-image').forEach(btn => {
            btn.addEventListener('click', function () {

                if (!confirm('¿Eliminar esta imagen?')) return;

                const form = document.getElementById('deleteImageForm');
                form.action = this.dataset.action;
                form.submit();
            });
        });
    </script>
@endpush