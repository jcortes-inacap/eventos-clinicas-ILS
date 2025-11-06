<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLugarRequest;
use App\Http\Requests\UpdateLugarRequest;
use App\Models\Lugar;
use App\Services\LugarService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de recursos para la gestión de lugares.
 * Implementa las operaciones CRUD siguiendo las mejores prácticas de Laravel.
 */
class LugarController extends Controller
{
    /**
     * Service que contiene la lógica de negocio.
     */
    protected LugarService $lugarService;

    /**
     * Inyectar el servicio de lugares.
     */
    public function __construct(LugarService $lugarService)
    {
        $this->lugarService = $lugarService;
    }

    /**
     * LISTAR TODOS LOS LUGARES
     * GET /api/lugares
     */
    public function index(): JsonResponse
    {
        $lugares = $this->lugarService->getAllLugares();
        
        return response()->json([
            'success' => true,
            'data' => $lugares
        ]);
    }

    /**
     * MOSTRAR UN LUGAR ESPECÍFICO
     * GET /api/lugares/{lugar}
     * Route Model Binding: Laravel automáticamente devuelve 404 si no existe
     */
    public function show(Lugar $lugar): JsonResponse
    {
        $lugar = $this->lugarService->getLugarWithRelations($lugar);

        return response()->json([
            'success' => true,
            'data' => $lugar
        ]);
    }

    /**
     * CREAR UN NUEVO LUGAR
     * POST /api/lugares
     * Validación automática mediante StoreLugarRequest
     */
    public function store(StoreLugarRequest $request): JsonResponse
    {
        $lugar = $this->lugarService->createLugar($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lugar creado exitosamente',
            'data' => $lugar
        ], 201);
    }

    /**
     * ACTUALIZAR UN LUGAR EXISTENTE
     * PUT/PATCH /api/lugares/{lugar}
     * Validación y autorización mediante UpdateLugarRequest
     */
    public function update(UpdateLugarRequest $request, Lugar $lugar): JsonResponse
    {
        $lugar = $this->lugarService->updateLugar($lugar, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lugar actualizado exitosamente',
            'data' => $lugar
        ]);
    }

    /**
     * ELIMINAR UN LUGAR
     * DELETE /api/lugares/{lugar}
     * Solo se puede eliminar si no tiene eventos asociados
     */
    public function destroy(Lugar $lugar): JsonResponse
    {
        try {
            $this->lugarService->deleteLugar($lugar);

            return response()->json([
                'success' => true,
                'message' => 'Lugar eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409); // 409 Conflict
        }
    }

    /**
     * FILTRAR LUGARES POR TIPO
     * GET /api/lugares/filtrar/tipo/{tipo}
     */
    public function filtrarPorTipo(string $tipo): JsonResponse
    {
        $lugares = $this->lugarService->filterByTipo($tipo);

        return response()->json([
            'success' => true,
            'data' => $lugares
        ]);
    }

    /**
     * BUSCAR LUGARES POR NOMBRE
     * GET /api/lugares/buscar/{nombre}
     */
    public function buscarPorNombre(string $nombre): JsonResponse
    {
        $lugares = $this->lugarService->searchByNombre($nombre);

        return response()->json([
            'success' => true,
            'data' => $lugares
        ]);
    }

    /**
     * OBTENER LUGARES CON CANTIDAD DE EVENTOS
     * GET /api/lugares/con-eventos
     */
    public function lugaresConEventos(): JsonResponse
    {
        $lugares = $this->lugarService->getLugaresWithEventosCount();

        return response()->json([
            'success' => true,
            'data' => $lugares
        ]);
    }
}
