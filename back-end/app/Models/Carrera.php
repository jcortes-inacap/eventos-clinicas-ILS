<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

// Carrera.php
class Carrera extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id_carrera';
    public $timestamps = false;

    protected $fillable = [
        // 'id_carrera',
        'descripcion',
        'estado',
    ];

    public function usuarios() // Relación con el modelo Usuario, una carrera tiene muchos usuarios, se usa hasMany con dos claves foráneas para definir la relación
    {
        return $this->hasMany(Usuario::class, 'id_carrera', 'id_carrera');
    }
}

