<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Base de Area.php
class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        //El 'id_area' está como auto incrementable
        'descripcion',
        'estado',
    ];

    public function carrera()
    {
        return $this->hasMany(Carrera::class, 'id_area', 'id_area');
    }
}
