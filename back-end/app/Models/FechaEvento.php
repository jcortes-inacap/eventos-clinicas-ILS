<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FechaEvento extends Model
{
    use HasFactory;

    // Nombre de la tabla en PostgreSQL
    protected $table = 'fecha_evento';
    
    // Clave primaria personalizada
    protected $primaryKey = 'id_fecha';
    
    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id_fecha';
    }

    // Campos
    protected $fillable = [
        'id_evento',
        'fecha',
    ];

    // Tratados como tipos específicos
    protected $casts = [
        'fecha' => 'date:Y-m-d',
    ];

    // Serialización para API
    protected $dateFormat = 'Y-m-d';

    // ============================================
    // RELACIONES
    // ============================================

    /**
     * Una fecha pertenece a un evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Una fecha puede tener muchos bloques
     * NOTA: Descomentar cuando el modelo Bloque esté creado
     */
    // public function bloques()
    // {
    //     return $this->hasMany(Bloque::class, 'id_fecha', 'id_fecha');
    // }

    // ============================================
    // SCOPES (Filtros reutilizables)
    // ============================================

    /**
     * Obtener fechas futuras (incluyendo hoy)
     */
    public function scopeFuturas($query)
    {
        return $query->where('fecha', '>=', Carbon::today());
    }

    /**
     * Obtener fechas pasadas
     */
    public function scopePasadas($query)
    {
        return $query->where('fecha', '<', Carbon::today());
    }

    /**
     * Obtener fechas de un evento específico
     */
    public function scopePorEvento($query, $idEvento)
    {
        return $query->where('id_evento', $idEvento);
    }

    /**
     * Obtener fechas en un rango
     */
    public function scopeEnRango($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    /**
     * Ordenar por fecha ascendente
     */
    public function scopeOrdenadaPorFecha($query)
    {
        return $query->orderBy('fecha', 'asc');
    }

    /**
     * Asegurar que la fecha se devuelva siempre en formato Y-m-d para la API
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Verificar si la fecha es futura
     */
    public function esFutura()
    {
        return $this->fecha >= Carbon::today();
    }

    /**
     * Verificar si la fecha es pasada
     */
    public function esPasada()
    {
        return $this->fecha < Carbon::today();
    }

    /**
     * Verificar si la fecha es hoy
     */
    public function esHoy()
    {
        return $this->fecha->isToday();
    }

    /**
     * Obtener días restantes hasta la fecha
     */
    public function diasRestantes()
    {
        return Carbon::today()->diffInDays($this->fecha, false);
    }

    /**
     * Verificar si tiene bloques asociados
     * NOTA: Descomentar cuando el modelo Bloque esté creado
     */
    // public function tieneBloques()
    // {
    //     return $this->bloques()->exists();
    // }
}
