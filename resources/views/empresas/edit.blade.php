@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Editar Empresa</h1>
    </div>


    <form method="POST" action="{{ route('empresas.update', $empresa) }}">
        @csrf
        @method('PUT')

        @include('empresas._form')

        <div class="d-flex justify-content-end gap-2 mt-3">

            <button class="btn btn-primary btn-sm btn-nuevo">Actualizar</button>
            <a href="{{ route('empresas.index') }}" class="btn btn-secondary btn-sm btn-nuevo">Volver</a>

        </div>
    </form>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const region = document.getElementById('region');
            const provincia = document.getElementById('provincia');
            const distrito = document.getElementById('distrito');

            const provinciaSeleccionada = @json($provinciaSeleccionada ?? null);
            const distritoSeleccionado = @json($distritoSeleccionado ?? null);

            // ===============================
            // CARGAR PROVINCIAS
            // ===============================
            region.addEventListener('change', async () => {
                provincia.innerHTML = '<option value="">Cargando...</option>';
                distrito.innerHTML = '<option value="">Seleccione distrito</option>';

                if (!region.value) return;

                const res = await fetch(`/provincias/${region.value}`);
                const data = await res.json();

                provincia.innerHTML = '<option value="">Seleccione</option>';
                data.forEach(p => {
                    provincia.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
            });

            // ===============================
            // CARGAR DISTRITOS
            // ===============================
            provincia.addEventListener('change', async () => {
                distrito.innerHTML = '<option value="">Cargando...</option>';

                if (!provincia.value) return;

                const res = await fetch(`/distritos/${provincia.value}`);
                const data = await res.json();

                distrito.innerHTML = '<option value="">Seleccione</option>';
                data.forEach(d => {
                    distrito.innerHTML += `<option value="${d.id}">${d.nombre}</option>`;
                });
            });

            // ===============================
            // PRECARGA EN EDIT
            // ===============================
            if (region.value) {
                fetch(`/provincias/${region.value}`)
                    .then(r => r.json())
                    .then(data => {
                        provincia.innerHTML = '<option value="">Seleccione</option>';
                        data.forEach(p => {
                            provincia.innerHTML += `
                                <option value="${p.id}" ${p.id == provinciaSeleccionada ? 'selected' : ''}>
                                    ${p.nombre}
                                </option>`;
                        });

                        if (provinciaSeleccionada) {
                            return fetch(`/distritos/${provinciaSeleccionada}`);
                        }
                    })
                    .then(r => r ? r.json() : [])
                    .then(data => {
                        if (!data) return;

                        distrito.innerHTML = '<option value="">Seleccione</option>';
                        data.forEach(d => {
                            distrito.innerHTML += `
                                <option value="${d.id}" ${d.id == distritoSeleccionado ? 'selected' : ''}>
                                    ${d.nombre}
                                </option>`;
                        });
                    });
            }
        });
    </script>
@endpush