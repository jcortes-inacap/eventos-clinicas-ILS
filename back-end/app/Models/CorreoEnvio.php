<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreoEnvio extends Model
{
    use HasFactory;

    protected $table = 'correo_envio';
    protected $primaryKey = 'id_envio';
    public $timestamps = false;

    protected $fillable = [
        'id_evento',
        'asunto',
        'mensaje',
        'fecha_envio',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    /**
     * Un correo pertenece a un evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
