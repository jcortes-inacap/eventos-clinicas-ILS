<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Area;

class CarreraController extends Controller
{

    //Función para listar
    public function index(Request $request)
    {
        $query = Carrera::with('area');

        if ($request->has('estado')) {
        $estado = $request->estado;
        if (is_array($estado)) {
            $query->whereIn('estado', $estado);
        } else {
            $query->where('estado', $estado);
        }
        }


        if ($request->has('id_area')) {
            $query->where('id_area', $request->id_area);
        }

        return response()->json(['data' => $query->get()]);
    }



    //Función para crear
    public function create()
    {
        $areas = Area::all();
        return response()->json($areas);
    }

    //Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_area' => 'required|exists:areas,id_area',
            'estado' => 'required|in:0,1',
        ]);

        $carrera = Carrera::create($validated);

        return response()->json(['id_carrera' => $carrera->id_carrera], 201);
    }


    //Mostrar
    public function show(Carrera $carrera)
    {
        $carrera->load('area');
        return response()->json($carrera);
    }


    //Editar
    public function edit(Carrera $carrera)
    {
        $areas = Area::all();
        return response()->json([
            'carrera' => $carrera,
            'areas' => $areas
        ]);
    }


    //Editar
    public function update(Request $request, Carrera $carrera)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:150',
            'estado' => 'required|integer|in:0,1',
            'id_area' => 'required|exists:areas,id_area'
        ]);

        $carrera->update($data);
        return response()->json($carrera);
    }



    //Desactivación

    public function softDelete(Carrera $carrera)
    {
        $carrera->estado = 0;
        $carrera->save();
        return response()->json(['mensaje' => 'Carrera desactivada']);
    }


    public function destroy(Carrera $carrera)
    {
        $carrera->update(['estado' => 0]);
        return response()->json(['mensaje' => 'Carrera desactivada']);
    }

    public function toggle($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->estado = $carrera->estado === 1 ? 0 : 1;
        $carrera->save();

        return response()->json([
            'id' => $carrera->id_carrera,
            'estado' => $carrera->estado,
            'mensaje' => $carrera->estado === 1 ? 'Carrera activada' : 'Carrera desactivada'
        ]);
    }



}
