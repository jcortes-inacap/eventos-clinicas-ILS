<?php

namespace App\Services;

use App\Models\FechaEvento;
use Illuminate\Database\Eloquent\Collection;

class FechaEventoService
{
    /**
     * Obtener todas las fechas de eventos con sus relaciones.
     */
    public function getAllFechas(): Collection
    {
        return FechaEvento::with(['evento.lugar', 'evento.usuario'])
            ->ordenadaPorFecha()
            ->get();
    }

    /**
     * Obtener una fecha de evento con todas sus relaciones.
     */
    public function getFechaWithRelations(FechaEvento $fechaEvento): FechaEvento
    {
        return $fechaEvento->load([
            'evento.lugar',
            'evento.usuario.rol',
            'evento.usuario.carrera'
        ]);
    }

    /**
     * Crear una nueva fecha de evento.
     */
    public function createFecha(array $data): FechaEvento
    {
        $fechaEvento = FechaEvento::create($data);
        
        return $fechaEvento->load(['evento.lugar', 'evento.usuario']);
    }

    /**
     * Actualizar una fecha de evento existente.
     */
    public function updateFecha(FechaEvento $fechaEvento, array $data): FechaEvento
    {
        $fechaEvento->update($data);
        
        return $fechaEvento->load(['evento.lugar', 'evento.usuario']);
    }

    /**
     * Eliminar una fecha de evento (eliminación física).
     */
    public function deleteFecha(FechaEvento $fechaEvento): bool
    {
        return $fechaEvento->delete();
    }

    /**
     * Obtener todas las fechas de un evento específico.
     */
    public function getFechasByEvento(int $idEvento): Collection
    {
        return FechaEvento::porEvento($idEvento)
            ->with(['evento.lugar'])
            ->ordenadaPorFecha()
            ->get();
    }
}
