<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

// Usuario.php
// Rol.php
class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_roles';
    public $timestamps = false;

    protected $fillable = [
        // 'id_Roles',
        'descripcion',
        'estado',
    ];

    public function usuarios() // Relación con el modelo Usuario, un rol tiene muchos usuarios, se usa hasMany con dos claves foráneas para definir la relación
    {
        return $this->hasMany(Usuario::class, 'id_roles', 'id_roles');
    }
}
