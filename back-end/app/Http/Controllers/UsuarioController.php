<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function destroy(Usuario $usuario)
    {
        // Usar soft delete en lugar de eliminación física
        $usuario->softDelete();
        return response()->json(['message' => 'Usuario desactivado correctamente']);
    }

    // Mostrar todos los usuarios ACTIVOS por defecto
    public function showAll()
    {
        $usuarios = Usuario::active()->with(['rol', 'carrera'])->get();
        return response()->json($usuarios);
    }

    // Mostrar todos los usuarios (incluyendo inactivos)
    public function showAllWithInactive()
    {
        $usuarios = Usuario::with(['rol', 'carrera'])->get();
        return response()->json($usuarios);
    }

    // Mostrar solo usuarios inactivos
    public function showInactive()
    {
        $usuarios = Usuario::inactive()->with(['rol', 'carrera'])->get();
        return response()->json($usuarios);
    }

    public function showOne($usuarioId)
    {
        // Buscar usuario sin importar su estado
        $usuario = Usuario::with(['rol', 'carrera'])->find($usuarioId);
        return $usuario ? response()->json($usuario) : response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    // Método para restaurar usuario
    public function restore($usuarioId)
    {
        // Buscar usuario sin importar su estado
        $usuario = Usuario::find($usuarioId);
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->restore();
        return response()->json(['message' => 'Usuario restaurado correctamente']);
    }
}
