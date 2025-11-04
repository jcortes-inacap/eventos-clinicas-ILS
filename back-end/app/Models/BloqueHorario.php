<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueHorario extends Model
{
    use HasFactory;

    protected $table = 'bloque_horario';
    protected $primaryKey = 'id_bloquehorario';
    public $timestamps = false;

    protected $fillable = [
        'id_bloque',
        'id_evento',
        'descripcion',
    ];

    /**
     * Un bloque horario pertenece a un bloque
     */
    public function bloque()
    {
        return $this->belongsTo(Bloque::class, 'id_bloque', 'id_bloque');
    }

    /**
     * Un bloque horario pertenece a un evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Un bloque horario puede tener cupos
     */
    public function cupos()
    {
        return $this->hasOne(Cupos::class, 'id_bloquehorario', 'id_bloquehorario');
    }

    /**
     * Un bloque horario puede tener muchas inscripciones
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_bloquehorario', 'id_bloquehorario');
    }
}
