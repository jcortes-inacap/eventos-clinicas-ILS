<?php

namespace App\Services;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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
        // Remover qr_url si viene en los datos (se genera automáticamente)
        unset($data['qr_url']);
        
        $evento = Evento::create($data);
        
        // Generar QR automáticamente después de crear el evento
        $this->generarQR($evento);
        
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



    /**
     * Generar código QR para un evento.
     */
    public function generarQR(Evento $evento): string
    {
        // Si ya tiene QR, retornarlo
        if ($evento->qr_url) {
            return $evento->qr_url;
        }

        // URL del evento en el frontend 
        $contenidoQR = config('app.url') . "/eventos/" . $evento->id_evento;
        
        // Generar QR en formato SVG 
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString($contenidoQR);

        // Nombre del archivo
        $fileName = 'qrs/evento_' . $evento->id_evento . '.svg';
        
        Storage::disk('public')->put($fileName, $qrSvg);

        // Actualizar la URL del QR en la base de datos
        $qrUrl = 'storage/' . $fileName;
        $evento->update(['qr_url' => $qrUrl]);

        return $qrUrl;
    }
}
