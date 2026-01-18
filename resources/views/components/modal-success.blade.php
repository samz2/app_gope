@if(session('modal_success'))
@php
    $data = session('modal_success');
@endphp

<div class="modal fade show" id="successModal" tabindex="-1" style="display:block;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg border-0">

            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:48px;"></i>
                </div>

                <h5 class="fw-semibold">{{ $data['title'] ?? 'Éxito' }}</h5>
                <p class="text-muted mb-4">
                    {{ $data['message'] ?? 'Acción realizada correctamente.' }}
                </p>

                <a href="{{ $data['redirect'] ?? url()->current() }}"
                   class="btn btn-success px-4">
                    OK
                </a>
            </div>

        </div>
    </div>
</div>

<div class="modal-backdrop fade show"></div>

<script>
    // Auto redirect después de 3 segundos
    setTimeout(() => {
        window.location.href = "{{ $data['redirect'] ?? url()->current() }}";
    }, 3000);
</script>
@endif
