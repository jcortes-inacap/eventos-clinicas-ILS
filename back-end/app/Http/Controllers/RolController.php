<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Mostrar todos los roles activos
     */
    public function index()
    {
        $roles = Rol::where('estado', 1)->get();
        return response()->json($roles, 200);
    }

    /**
     * Mostrar un rol específico
     */
    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol, 200);
    }

    /**
     * Crear un nuevo rol
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:150',
        ]);

        $rol = Rol::create([
            'descripcion' => $request->descripcion,
            'estado' => 1,
        ]);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'rol' => $rol
        ], 201);
    }

    /**
     * Actualizar un rol existente
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $request->validate([
            'descripcion' => 'required|string|max:150',
            'estado' => 'nullable|integer|in:0,1',
        ]);

        $rol->update($request->only(['descripcion', 'estado']));

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'rol' => $rol
        ], 200);
    }

    /**
     * Eliminar (o desactivar) un rol
     */
    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        // Desactivar un rol
        $rol->update(['estado' => 0]);

        return response()->json(['message' => 'Rol desactivado correctamente'], 200);
    }
}
