@props([
    'id' => 'confirmModal',
    'title' => 'Confirmación',
    'message' => '¿Está seguro de realizar esta acción?',
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center py-4">
                <p class="mb-0">{{ $message }}</p>
            </div>

            <div class="modal-footer justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button"
                        class="btn btn-danger px-4"
                        id="confirmDeleteBtn">
                    Sí, eliminar
                </button>
            </div>

        </div>
    </div>
</div>
