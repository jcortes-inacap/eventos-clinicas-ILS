<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFechaEventoRequest;
use App\Http\Requests\UpdateFechaEventoRequest;
use App\Models\FechaEvento;
use App\Services\FechaEventoService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de recursos para la gestión de fechas de eventos.
 * Implementa las operaciones CRUD siguiendo las mejores prácticas de Laravel.
 */
class FechaEventoController extends Controller
{
    /**
     * Service que contiene la lógica de negocio.
     */
    protected FechaEventoService $fechaEventoService;

    /**
     * Inyectar el servicio de fechas de eventos.
     */
    public function __construct(FechaEventoService $fechaEventoService)
    {
        $this->fechaEventoService = $fechaEventoService;
    }

    /**
     * LISTAR TODAS LAS FECHAS DE EVENTOS
     * GET /api/fechas-evento
     */
    public function index(): JsonResponse
    {
        $fechas = $this->fechaEventoService->getAllFechas();
        
        return response()->json([
            'success' => true,
            'data' => $fechas
        ]);
    }

    /**
     * MOSTRAR UNA FECHA ESPECÍFICA
     * GET /api/fechas-evento/{fechaEvento}
     * Route Model Binding: Laravel automáticamente devuelve 404 si no existe
     */
    public function show(FechaEvento $fechaEvento): JsonResponse
    {
        $fechaEvento = $this->fechaEventoService->getFechaWithRelations($fechaEvento);

        return response()->json([
            'success' => true,
            'data' => $fechaEvento
        ]);
    }

    /**
     * CREAR UNA NUEVA FECHA DE EVENTO
     * POST /api/fechas-evento
     * Validación automática mediante StoreFechaEventoRequest
     */
    public function store(StoreFechaEventoRequest $request): JsonResponse
    {
        $fechaEvento = $this->fechaEventoService->createFecha($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fecha de evento creada exitosamente',
            'data' => $fechaEvento
        ], 201);
    }

    /**
     * ACTUALIZAR UNA FECHA DE EVENTO EXISTENTE
     * PUT/PATCH /api/fechas-evento/{fechaEvento}
     * Validación mediante UpdateFechaEventoRequest
     */
    public function update(UpdateFechaEventoRequest $request, FechaEvento $fechaEvento): JsonResponse
    {
        $fechaEvento = $this->fechaEventoService->updateFecha($fechaEvento, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fecha de evento actualizada exitosamente',
            'data' => $fechaEvento
        ]);
    }

    /**
     * ELIMINAR UNA FECHA DE EVENTO (ELIMINACIÓN FÍSICA)
     * DELETE /api/fechas-evento/{fechaEvento}
     */
    public function destroy(FechaEvento $fechaEvento): JsonResponse
    {
        $this->fechaEventoService->deleteFecha($fechaEvento);

        return response()->json([
            'success' => true,
            'message' => 'Fecha de evento eliminada exitosamente'
        ]);
    }

    /**
     * OBTENER TODAS LAS FECHAS DE UN EVENTO ESPECÍFICO
     * GET /api/fechas-evento/evento/{idEvento}
     */
    public function fechasPorEvento(int $idEvento): JsonResponse
    {
        $fechas = $this->fechaEventoService->getFechasByEvento($idEvento);

        return response()->json([
            'success' => true,
            'data' => $fechas
        ]);
    }
}
