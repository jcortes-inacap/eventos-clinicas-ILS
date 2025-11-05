<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    //Listar
    public function index(Request $request)
{
    $query = Area::query();

    if ($request->has('estado')) {
        $query->where('estado', $request->estado);
    }

    if ($request->has('descripcion')) {
        $query->where('descripcion', 'like', '%' . $request->descripcion . '%');
    }

    return response()->json(['data' => $query->get()]);
}


    //Crear
    public function create()
    {
        return response()->json(['mensaje' => 'Formulario de creación no aplica en JSON']);
    }


    //Store
    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:150',
            'estado' => 'required|integer|in:0,1'
        ]);

        $area = Area::create($data);
        return response()->json($area, 201);
    }

    //Mostrar
    public function show($id)
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        return response()->json($area);
    }


    //Editar
    public function edit(Area $area)
    {
        return response()->json(['area' => $area]);
    }

    //Actualizar
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|in:0,1'
        ]);

        $area->update($request->only(['descripcion', 'estado']));

        return redirect('/roles-permissions/permissions/list')
            ->with('success', 'Área actualizada correctamente');
    }



    //Eliminar
    public function destroy(Area $area)
{
    $area->update(['estado' => 0]);
    return response()->json(['mensaje' => 'Area desactivada']);
}


    //Ocultar
    public function softDelete(Area $area)
    {
        $area->estado = 0;
        $area->save();
        return response()->json(['mensaje' => 'Área desactivada']);
    }

    public function toggleEstado(Area $area)
    {
        if ($area->estado === 1) {
            $area->estado = 0;
            $mensaje = 'Área desactivada';
        } else {
            $area->estado = 1;
            $mensaje = 'Área activada';
        }

        $area->save();

        return response()->json(['mensaje' => $mensaje]);
    }

}