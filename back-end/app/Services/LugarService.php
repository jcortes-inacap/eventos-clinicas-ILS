<?php

namespace App\Services;

use App\Models\Lugar;
use Illuminate\Database\Eloquent\Collection;

/**
 * Servicio que contiene la lógica de negocio para la gestión de lugares.
 * Separa la lógica de negocio del controlador siguiendo las mejores prácticas.
 */
class LugarService
{
    /**
     * Obtener todos los lugares activos.
     */
    public function getAllLugares(): Collection
    {
        return Lugar::orderBy('nombre', 'asc')->get();
    }

    /**
     * Obtener un lugar con sus relaciones.
     */
    public function getLugarWithRelations(Lugar $lugar): Lugar
    {
        return $lugar->load(['eventos']);
    }

    /**
     * Crear un nuevo lugar.
     */
    public function createLugar(array $data): Lugar
    {
        return Lugar::create($data);
    }

    /**
     * Actualizar un lugar existente.
     */
    public function updateLugar(Lugar $lugar, array $data): Lugar
    {
        $lugar->update($data);
        return $lugar->fresh();
    }

    /**
     * Eliminar un lugar (eliminación física si no tiene eventos asociados).
     */
    public function deleteLugar(Lugar $lugar): bool
    {
        // Verificar si tiene eventos asociados
        if ($lugar->eventos()->count() > 0) {
            throw new \Exception('No se puede eliminar el lugar porque tiene eventos asociados');
        }

        return $lugar->delete();
    }

    /**
     * Filtrar lugares por tipo.
     */
    public function filterByTipo(string $tipo): Collection
    {
        return Lugar::where('tipo', $tipo)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Buscar lugares por nombre.
     */
    public function searchByNombre(string $nombre): Collection
    {
        return Lugar::where('nombre', 'ILIKE', "%{$nombre}%")
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * Obtener lugares con la cantidad de eventos.
     */
    public function getLugaresWithEventosCount(): Collection
    {
        return Lugar::withCount('eventos')
            ->orderBy('nombre', 'asc')
            ->get();
    }
}
