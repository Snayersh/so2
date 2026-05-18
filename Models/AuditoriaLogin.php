<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaLogin extends Model
{
    protected $table = 'auditoria_login';
    protected $primaryKey = 'id_registro';
    public $timestamps = false;

    protected $fillable = [
        'correo_intento',
        'ip_origen',
        'exitoso',
        'fecha_intento',
        'detalles_navegador'
    ];

    protected $casts = [
        'exitoso' => 'boolean'
    ];
}
