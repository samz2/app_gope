@extends('layouts.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Empresas</h1>

    <a href="{{ route('empresas.create') }}" class="btn btn-primary">
        + Nueva Empresa
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('empresas.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Buscar empresa..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Buscar
                    </button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Representante</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        {{-- <th>Latitud</th>
                        <th>Longitud</th> --}}
                        <th>Estado</th>
                        <th>Departamento</th>
                        <th>Provincia</th>
                        <th>Distrito</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-empresas">
                    @include('empresas.partials.table')
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $empresas->links() }}
        </div>
    </div>
</div>
<script>
    document.querySelector('input[name="search"]').addEventListener('keyup', function () {
        fetch(`?search=${this.value}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.querySelector('#tabla-empresas').innerHTML = html;
        });
    });
</script>
@endsection
