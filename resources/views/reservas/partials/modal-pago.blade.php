<div class="modal fade" id="pagoModal{{ $reserva->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('reservas.pagar', $reserva) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Monto pagado</label>
                        <input type="number" step="0.01" name="monto_pagado" class="form-control"
                            value="{{ $reserva->precio }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de pago</label>
                        <select name="metodo_pago" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="yape">Yape</option>
                            <option value="plin">Plin</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        Confirmar pago
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>