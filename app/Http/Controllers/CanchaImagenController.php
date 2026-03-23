<?php

namespace App\Http\Controllers;

use App\Models\CanchaImagen;
use Illuminate\Support\Facades\Storage;

class CanchaImagenController extends Controller
{
    public function destroy(CanchaImagen $imagen)
    {
        $user = auth()->user();
        $cancha = $imagen->cancha;

        // 🔒 Seguridad: empresa solo puede borrar imágenes de SU cancha
        if (
            $user->role->nombre === 'empresa' &&
            $cancha->empresa_id !== $user->empresa->id
        ) {
            abort(403);
        }

        // 🧹 Borrar archivo físico
        if (Storage::disk('public')->exists($imagen->ruta)) {
            Storage::disk('public')->delete($imagen->ruta);
        }

        // 🗑️ Borrar registro
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente');
    }
}
