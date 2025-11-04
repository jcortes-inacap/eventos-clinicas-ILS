<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    // Nombre de la tabla en PostgreSQL
    protected $table = 'evento';
    
    // Clave primaria personalizada
    protected $primaryKey = 'id_evento';
    
    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id_evento';
    }

    // Campos 
    protected $fillable = [
        'titulo',
        'descripcion',
        'afiche_grafico',
        'visibilidad',
        'modalidad',
        'qr_url',
        'requiere_estacionamiento',
        'duracion',
        'estado',
        'id_lugar',
        'id_usuarios',
    ];

    // tratados como tipos específicos
    protected $casts = [
        'requiere_estacionamiento' => 'boolean',
        'duracion' => 'integer',
        'estado' => 'integer',
    ];

    // ============================================
    // RELACIONES 
    // ============================================

    /**
     * Un evento pertenece a un lugar
     */
    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'id_lugar', 'id_lugar');
    }

    /**
     * Un evento es creado por un usuario (jefe de carrera)
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuarios', 'id_usuarios');
    }

    /**
     * Un evento puede tener muchas fechas
     */
    public function fechas()
    {
        return $this->hasMany(FechaEvento::class, 'id_evento', 'id_evento');
    }

    /**
     * Un evento puede tener muchos bloques de horario
     */
    public function bloquesHorario()
    {
        return $this->hasMany(BloqueHorario::class, 'id_evento', 'id_evento');
    }

    /**
     * Un evento puede tener muchos correos enviados
     */
    public function correosEnviados()
    {
        return $this->hasMany(CorreoEnvio::class, 'id_evento', 'id_evento');
    }

    // ============================================
    // SCOPES (Filtros reutilizables)
    // ============================================

    /**
     * Obtener solo eventos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('visibilidad', 'publico');
    }

    /**
     * Obtener solo eventos privados
     */
    public function scopePrivados($query)
    {
        return $query->where('visibilidad', 'privado');
    }

    /**
     * Obtener solo eventos internos
     */
    public function scopeInternos($query)
    {
        return $query->where('visibilidad', 'interno');
    }

    /**
     * Obtener eventos por modalidad
     */
    public function scopePorModalidad($query, $modalidad)
    {
        return $query->where('modalidad', $modalidad);
    }

    /**
     * Obtener eventos de un usuario específico
     */
    public function scopeDelUsuario($query, $idUsuario)
    {
        return $query->where('id_usuarios', $idUsuario);
    }

    /**
     * Obtener solo eventos activos (estado = 1)
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Obtener solo eventos inactivos/eliminados (estado = 0)
     */
    public function scopeInactivos($query)
    {
        return $query->where('estado', 0);
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Verificar si el evento está activo
     */
    public function estaActivo()
    {
        return $this->estado === 1;
    }

    /**
     * Activar el evento
     */
    public function activar()
    {
        $this->estado = 1;
        return $this->save();
    }

    /**
     * Desactivar/Eliminar el evento (soft delete)
     */
    public function desactivar()
    {
        $this->estado = 0;
        return $this->save();
    }

    /**
     * Verificar si el evento es público
     */
    public function esPublico()
    {
        return $this->visibilidad === 'publico';
    }

    /**
     * Verificar si el evento es presencial
     */
    public function esPresencial()
    {
        return $this->modalidad === 'presencial';
    }

    /**
     * Verificar si requiere estacionamiento
     */
    public function requiereEstacionamiento()
    {
        return $this->requiere_estacionamiento === true;
    }
}
