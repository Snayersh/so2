<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_rol',
        'correo',
        'hash_password',
        'intentos_fallidos',
        'cuenta_bloqueada',
        'fecha_creacion',
        'ultimo_acceso'
    ];

    // Ocultar datos sensibles cuando el modelo sea serializado (ej. a JSON o Array)
    protected $hidden = [
        'hash_password',
    ];

    protected $casts = [
        'cuenta_bloqueada' => 'boolean',
        'intentos_fallidos' => 'integer'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
}
