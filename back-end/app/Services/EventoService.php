<?php

namespace App\Services;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Collection;

class EventoService
{
    /**
     * Obtener todos los eventos activos con sus relaciones.
     */
    public function getAllEventos(): Collection
    {
        return Evento::activos()
            ->with(['lugar', 'usuario.rol', 'usuario.carrera'])
            ->get();
    }

    /**
     * Obtener un evento con todas sus relaciones.
     */
    public function getEventoWithRelations(Evento $evento): Evento
    {
        return $evento->load([
            'lugar',
            'usuario.rol',
            'usuario.carrera',
            'fechas',
            'bloquesHorario'
        ]);
    }

    /**
     * Crear un nuevo evento.
     */
    public function createEvento(array $data): Evento
    {
        $evento = Evento::create($data);
        
        return $evento->load(['lugar', 'usuario.rol', 'usuario.carrera']);
    }

    /**
     * Actualizar un evento existente.
     */
    public function updateEvento(Evento $evento, array $data): Evento
    {
        $evento->update($data);
        
        return $evento->load(['lugar', 'usuario.rol', 'usuario.carrera']);
    }

    /**
     * Eliminar un evento (soft delete - cambiar estado a 0).
     */
    public function deleteEvento(Evento $evento): bool
    {
        return $evento->update(['estado' => 0]);
    }

    /**
     * Filtrar eventos por visibilidad.
     */
    public function filterByVisibilidad(string $tipo): Collection
    {
        return Evento::activos()
            ->where('visibilidad', $tipo)
            ->with(['lugar', 'usuario.rol', 'usuario.carrera'])
            ->get();
    }

    /**
     * Filtrar eventos por modalidad.
     */
    public function filterByModalidad(string $tipo): Collection
    {
        return Evento::activos()
            ->where('modalidad', $tipo)
            ->with(['lugar', 'usuario.rol', 'usuario.carrera'])
            ->get();
    }

    /**
     * Obtener eventos de un usuario específico.
     */
    public function getEventosByUsuario(int $idUsuario): Collection
    {
        return Evento::activos()
            ->where('id_usuarios', $idUsuario)
            ->with(['lugar', 'usuario.rol', 'usuario.carrera'])
            ->get();
    }
}
