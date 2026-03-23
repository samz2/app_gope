@extends('layouts.app')

@section('title', 'Nueva Reserva')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 style="font-size:22px;">Nueva Reserva</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf

                @include('reservas._form')

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('reservas.index') }}" class="btn btn-outline-danger btn-sm btn-nuevo">
                        Cancelar
                    </a>

                    <button type="submit" id="btn-guardar" class="btn btn-primary">
                        Guardar Reserva
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function verificarDisponibilidad() {
            let cancha = document.querySelector('[name="cancha_id"]').value;
            let fecha = document.querySelector('[name="fecha"]').value;
            let horaInicio = document.querySelector('[name="hora_inicio"]').value;
            let horaFin = document.querySelector('[name="hora_fin"]').value;

            if (cancha && fecha && horaInicio && horaFin) {
                fetch(`{{ route('reservas.verificarDisponibilidad') }}?cancha_id=${cancha}&fecha=${fecha}&hora_inicio=${horaInicio}&hora_fin=${horaFin}`)
                    .then(res => res.json())
                    .then(data => {

                        let info = document.getElementById('info-disponibilidad');
                        let btn = document.getElementById('btn-guardar');
                        let precioInput = document.querySelector('[name="precio"]');

                        if (data.disponible) {
                            // ✅ Disponible
                            info.innerHTML = `✅ Disponible | Bloque: ${data.bloque}`;
                            info.style.color = 'green';
                            info.style.display = 'block';


                            // 👉 Calcular precio automáticamente
                            buscarPrecio();

                            if (btn) btn.disabled = false;

                        } else {
                            // ❌ No disponible
                            info.innerHTML = '❌ ' + (data.mensaje ?? 'No disponible');
                            info.style.color = 'red';
                            info.style.display = 'block';

                            if (precioInput) precioInput.value = '';
                            if (btn) btn.disabled = true;
                        }
                    });
            }
        }

        // 🔎 Calcula precio según tarifa JSON
        function buscarPrecio() {
            let cancha = document.querySelector('[name="cancha_id"]').value;
            let fecha = document.querySelector('[name="fecha"]').value;
            let horaInicio = document.querySelector('[name="hora_inicio"]').value;
            let horaFin = document.querySelector('[name="hora_fin"]').value;

            if (cancha && fecha && horaInicio && horaFin) {
                fetch(`{{ route('reservas.buscarPrecio') }}?cancha_id=${cancha}&fecha=${fecha}&hora_inicio=${horaInicio}&hora_fin=${horaFin}`)
                    .then(res => res.json())
                    .then(data => {

                        let precioInput = document.querySelector('[name="precio"]');
                        let info = document.getElementById('info-disponibilidad');
                        let btn = document.getElementById('btn-guardar');

                        if (data.disponible) {
                            // 💰 Precio correcto
                            precioInput.value = data.total.toFixed(2);

                        } else {
                            // ⚠️ No existe tarifa válida
                            precioInput.value = '';
                            info.innerHTML = '⚠️ ' + (data.mensaje ?? 'No existe tarifa para este horario');
                            info.style.color = 'orange';
                            if (btn) btn.disabled = true;
                        }
                    });
            }
        }

        // 👂 Escuchamos cambios
        ['cancha_id', 'fecha', 'hora_inicio', 'hora_fin'].forEach(name => {
            let el = document.querySelector(`[name="${name}"]`);
            if (el) el.addEventListener('change', verificarDisponibilidad);
        });
    </script>
@endpush