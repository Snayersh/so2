<?php
require_once __DIR__ . '/bootstrap.php';

use App\Models\Rol;
use App\Models\Usuario;

// Crear un Rol Admin si no existe
$rolAdmin = Rol::firstOrCreate(
    ['nombre_rol' => 'Administrador'],
    ['descripcion' => 'Acceso total al sistema', 'estado' => true]
);

// Crear Usuario Admin de prueba si no existe
$correoAdmin = 'admin@empresa.com';
$passwordPlana = 'Admin1234!';

$usuario = Usuario::where('correo', $correoAdmin)->first();

if (!$usuario) {
    Usuario::create([
        'id_rol' => $rolAdmin->id_rol,
        'correo' => $correoAdmin,
        // Usar BCRYPT (o ARGON2ID si la versión de PHP/OS lo soporta perfectamente)
        'hash_password' => password_hash($passwordPlana, PASSWORD_BCRYPT),
        'intentos_fallidos' => 0,
        'cuenta_bloqueada' => false,
        'fecha_creacion' => date('Y-m-d H:i:s'),
    ]);
    echo "Usuario admin creado.\nCorreo: $correoAdmin\nContraseña: $passwordPlana\n";
} else {
    echo "El usuario admin ya existe.\n";
}
