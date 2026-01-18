<tbody>
    @forelse ($empresas as $empresa)
        <tr>
            <td>{{ $empresa->id }}</td>
            <td>{{ ucfirst($empresa->categoria) }}</td>
            <td>{{ $empresa->nombre }}</td>
            <td>{{ $empresa->documento }}</td>
            <td>{{ $empresa->representante }}</td>
            <td>{{ $empresa->direccion }}</td>
            <td>{{ $empresa->telefono }}</td>
            {{-- <td>{{ $empresa->latitud }}</td>
            <td>{{ $empresa->longitud }}</td> --}}
            <td>{{ $empresa->estado }}</td>
            <td>{{ $empresa->departamento_nombre ?? '-' }}</td>
            <td>{{ $empresa->provincia_nombre ?? '-' }}</td>
            <td>{{ $empresa->distrito_nombre ?? '-' }}</td>
            
            <td class="text-center">

                <!-- Editar -->
                <a href="{{ route('empresas.edit', $empresa) }}"
                class="btn btn-sm btn-warning"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Editar">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <!-- Eliminar -->
                <form action="{{ route('empresas.destroy', $empresa) }}"
                    method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Eliminar"
                            onclick="return confirm('¿Eliminar esta empresa?')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">
                No se encontraron resultados
            </td>
        </tr>
    @endforelse
</tbody>