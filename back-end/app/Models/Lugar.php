<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    // Nombre de la tabla en PostgreSQL
    protected $table = 'lugar';
    
    // Clave primaria personalizada
    protected $primaryKey = 'id_lugar';
    
    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id_lugar';
    }

    // Campos que se pueden llenar
    protected $fillable = [
        'nombre',
        'direccion',
        'tipo',
    ];

    // ============================================
    // RELACIONES 
    // ============================================

    /**
     * Un lugar puede tener muchos eventos
     */
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_lugar', 'id_lugar');
    }

    // ============================================
    // SCOPES (Filtros reutilizables)
    // ============================================

    /**
     * Filtrar lugares por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Buscar lugares por nombre (case-insensitive para PostgreSQL)
     */
    public function scopeBuscarNombre($query, $nombre)
    {
        return $query->where('nombre', 'ILIKE', "%{$nombre}%");
    }

    /**
     * Obtener lugares ordenados por nombre
     */
    public function scopeOrdenadoPorNombre($query)
    {
        return $query->orderBy('nombre', 'asc');
    }

    /**
     * Obtener lugares con eventos asociados
     */
    public function scopeConEventos($query)
    {
        return $query->has('eventos');
    }

    /**
     * Obtener lugares sin eventos asociados
     */
    public function scopeSinEventos($query)
    {
        return $query->doesntHave('eventos');
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================

    /**
     * Verificar si el lugar tiene eventos asociados
     */
    public function tieneEventos()
    {
        return $this->eventos()->count() > 0;
    }

    /**
     * Obtener la cantidad de eventos asociados
     */
    public function cantidadEventos()
    {
        return $this->eventos()->count();
    }

    /**
     * Verificar si se puede eliminar el lugar
     */
    public function puedeEliminarse()
    {
        return !$this->tieneEventos();
    }
}
