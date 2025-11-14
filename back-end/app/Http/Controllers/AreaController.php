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

    return response()->json($query->paginate(10));
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
    public function show(Area $area)
    {
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
        $data = $request->validate([
            'descripcion' => 'required|string|max:150',
            'estado' => 'required|integer|in:0,1'
        ]);

        $area->update($data);
        return response()->json($area);
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
}