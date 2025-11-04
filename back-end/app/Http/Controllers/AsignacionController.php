<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    public function update(Request $request, Usuario $usuario)
    {
        // Verificar que el usuario esté activo
        if (!$usuario->isActive()) {
            return response()->json(['error' => 'No se puede modificar un usuario inactivo'], 400);
        }

        $validated = $request->validate([
            'id_roles' => 'required|exists:roles,id_roles',
            'id_carrera' => 'nullable|exists:carreras,id_carrera',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'sometimes|string|max:150',
        ]);

        $usuario->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario->load(['rol', 'carrera'])
        ]);
    }
}
