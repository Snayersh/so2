<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/bootstrap.php'; // Carga Eloquent ORM

use App\Models\Usuario;
use App\Models\AuditoriaLogin;

// Prevenir acceso directo, solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$csrf_token = $_POST['csrf_token'] ?? '';
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$ip_origen = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// 1. Validar CSRF Token
if (!validate_csrf_token($csrf_token)) {
    $_SESSION['login_error'] = "Error de validación de seguridad (CSRF). Por favor, intenta de nuevo.";
    header("Location: index.php");
    exit;
}

// 2. Buscar usuario (Previene inyección SQL gracias a Eloquent)
$usuario = Usuario::where('correo', $correo)->first();

if (!$usuario) {
    // Para prevenir enumeración de usuarios (Account Enumeration), 
    // registramos el intento pero mostramos mensaje genérico.
    AuditoriaLogin::create([
        'correo_intento' => $correo,
        'ip_origen' => $ip_origen,
        'exitoso' => false,
        'detalles_navegador' => $user_agent
    ]);
    
    $_SESSION['login_error'] = "Credenciales incorrectas.";
    header("Location: index.php");
    exit;
}

// 3. Verificación de Cuenta Bloqueada
if ($usuario->cuenta_bloqueada) {
    AuditoriaLogin::create([
        'correo_intento' => $correo,
        'ip_origen' => $ip_origen,
        'exitoso' => false,
        'detalles_navegador' => $user_agent . ' (Intento en cuenta bloqueada)'
    ]);
    $_SESSION['login_error'] = "Esta cuenta ha sido bloqueada por múltiples intentos fallidos. Contacte a soporte.";
    header("Location: index.php");
    exit;
}

// 4. Verificación de Contraseña (usando BCRYPT o ARGON2ID por defecto de PHP password_hash)
if (password_verify($password, $usuario->hash_password)) {
    // Login Exitoso
    
    // Resetear intentos fallidos y actualizar fecha
    $usuario->intentos_fallidos = 0;
    $usuario->ultimo_acceso = date('Y-m-d H:i:s');
    $usuario->save();

    // Registrar auditoría exitosa
    AuditoriaLogin::create([
        'correo_intento' => $correo,
        'ip_origen' => $ip_origen,
        'exitoso' => true,
        'detalles_navegador' => $user_agent
    ]);

    // PROTECCIÓN CONTRA SESSION FIXATION: Regenerar el ID de la sesión fuertemente
    session_regenerate_id(true);

    // Guardar datos en sesión
    $_SESSION['user_id'] = $usuario->id_usuario;
    $_SESSION['user_role_id'] = $usuario->id_rol;
    $_SESSION['user_email'] = $usuario->correo;
    
    // Redirigir al dashboard
    header("Location: dashboard.php");
    exit;

} else {
    // Login Fallido - Lógica Anti-Fuerza Bruta
    
    $usuario->intentos_fallidos += 1;
    
    if ($usuario->intentos_fallidos >= 3) {
        $usuario->cuenta_bloqueada = true;
    }
    $usuario->save();

    // Registrar auditoría fallida
    AuditoriaLogin::create([
        'correo_intento' => $correo,
        'ip_origen' => $ip_origen,
        'exitoso' => false,
        'detalles_navegador' => $user_agent . ($usuario->cuenta_bloqueada ? ' (Cuenta Bloqueada por este intento)' : '')
    ]);

    $_SESSION['login_error'] = "Credenciales incorrectas.";
    header("Location: index.php");
    exit;
}
