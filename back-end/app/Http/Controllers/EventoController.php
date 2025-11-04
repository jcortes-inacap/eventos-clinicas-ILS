<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Models\Evento;
use App\Services\EventoService;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de recursos para la gestión de eventos.
 * Implementa las operaciones CRUD siguiendo las mejores prácticas de Laravel.
 */
class EventoController extends Controller
{
    /**
     * Service que contiene la lógica de negocio.
     */
    protected EventoService $eventoService;

    /**
     * Inyectar el servicio de eventos.
     */
    public function __construct(EventoService $eventoService)
    {
        $this->eventoService = $eventoService;
    }

    /**
     * LISTAR TODOS LOS EVENTOS
     * GET /api/eventos
     */
    public function index(): JsonResponse
    {
        $eventos = $this->eventoService->getAllEventos();
        
        return response()->json([
            'success' => true,
            'data' => $eventos
        ]);
    }

    /**
     * MOSTRAR UN EVENTO ESPECÍFICO
     * GET /api/eventos/{evento}
     * Route Model Binding: Laravel automáticamente devuelve 404 si no existe
     */
    public function show(Evento $evento): JsonResponse
    {
        $evento = $this->eventoService->getEventoWithRelations($evento);

        return response()->json([
            'success' => true,
            'data' => $evento
        ]);
    }

    /**
     * CREAR UN NUEVO EVENTO
     * POST /api/eventos
     * Validación automática mediante StoreEventoRequest
     */
    public function store(StoreEventoRequest $request): JsonResponse
    {
        $evento = $this->eventoService->createEvento($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Evento creado exitosamente',
            'data' => $evento
        ], 201);
    }

    /**
     * ACTUALIZAR UN EVENTO EXISTENTE
     * PUT/PATCH /api/eventos/{evento}
     * Validación y autorización mediante UpdateEventoRequest
     */
    public function update(UpdateEventoRequest $request, Evento $evento): JsonResponse
    {
        $evento = $this->eventoService->updateEvento($evento, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado exitosamente',
            'data' => $evento
        ]);
    }

    /**
     * ELIMINAR UN EVENTO (SOFT DELETE)
     * DELETE /api/eventos/{evento}
     * Cambia el estado a 0 en lugar de eliminarlo físicamente
     */
    public function destroy(Evento $evento): JsonResponse
    {
        $this->eventoService->deleteEvento($evento);

        return response()->json([
            'success' => true,
            'message' => 'Evento eliminado exitosamente'
        ]);
    }

    /**
     * FILTRAR EVENTOS POR VISIBILIDAD
     * GET /api/eventos/filtrar/visibilidad/{tipo}
     */
    public function filtrarPorVisibilidad(string $tipo): JsonResponse
    {
        $eventos = $this->eventoService->filterByVisibilidad($tipo);

        return response()->json([
            'success' => true,
            'data' => $eventos
        ]);
    }

    /**
     * FILTRAR EVENTOS POR MODALIDAD
     * GET /api/eventos/filtrar/modalidad/{tipo}
     */
    public function filtrarPorModalidad(string $tipo): JsonResponse
    {
        $eventos = $this->eventoService->filterByModalidad($tipo);

        return response()->json([
            'success' => true,
            'data' => $eventos
        ]);
    }

    /**
     * OBTENER EVENTOS DEL USUARIO ESPECÍFICO
     * GET /api/eventos/mis-eventos/{idUsuario}
     */
    public function misEventos(int $idUsuario): JsonResponse
    {
        $eventos = $this->eventoService->getEventosByUsuario($idUsuario);

        return response()->json([
            'success' => true,
            'data' => $eventos
        ]);
    }
}
