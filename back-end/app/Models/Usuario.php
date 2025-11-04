<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellidos',
        'usuario',
        'clave',
        'estado',
        'id_roles',
        'id_carrera',
    ];

    // Ocultar la clave al convertir el modelo a un array o JSON
    protected $hidden = [
        'clave',
    ];

    // Scope para obtener solo usuarios activos
    public function scopeActive($query)
    {
        return $query->where('estado', 1);
    }

    // Scope para obtener usuarios inactivos
    public function scopeInactive($query)
    {
        return $query->where('estado', 0);
    }

    // Método para "soft delete"
    public function softDelete()
    {
        return $this->update(['estado' => 0]);
    }

    // Método para restaurar usuario
    public function restore()
    {
        return $this->update(['estado' => 1]);
    }

    // Verificar si está activo
    public function isActive()
    {
        return $this->estado == 1;
    }

    // Relaciones basicamente un usuario pertenece a un rol y a una carrera (opcional)
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_roles', 'id_roles');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }
}
