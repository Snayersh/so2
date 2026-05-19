<?php
// Asegúrate de que el archivo de configuración de sesión estricta que me mostraste
// ya se haya ejecutado antes de llegar aquí (el que tiene session_start()).

/**
 * Función para destruir completamente la sesión de forma segura
 */
function destruir_sesion_segura() {
    // 1. Vaciar el arreglo de sesión
    $_SESSION = [];

    // 2. Borrar la cookie de sesión del navegador
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 3. Destruir la sesión en el servidor
    session_destroy();
}

/**
 * Lógica principal de validación (Equivalente a tu OnLoad en VB)
 */
function validar_acceso_estricto() {
    // 1. Verificamos si las variables de sesión existen
    if (isset($_SESSION['UserEmail']) && isset($_SESSION['TokenSesion'])) {
        
        $correo = $_SESSION['UserEmail'];
        $token = $_SESSION['TokenSesion'];

        // 2. Validación contra la Base de Datos
        // Aquí llamas a tu servicio o modelo para validar que el token coincida.
        // Simulando tu AccountValidacionService:
        $esValido = validar_token_bd($correo, $token); 

        if (!$esValido) {
            // ¡El token caducó o lo iniciaron en otro lado!
            destruir_sesion_segura();
            
            // Redirigir al login y detener ejecución
            header("Location: login.php?error=sesion_expirada");
            exit(); // Este es el "Freno de mano" equivalente a Return en VB
        }

        // 🔥 3. PROTECCIÓN EXTREMA DE CACHÉ (Bloquea el botón "Atrás")
        // Obliga al navegador a pedir la página al servidor siempre, en lugar de usar la memoria.
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Una fecha en el pasado
        
    } else {
        // No hay sesión en absoluto
        destruir_sesion_segura();
        header("Location: login.php");
        exit(); // Freno de mano
    }
}

// Ejecutamos la validación inmediatamente
validar_acceso_estricto();

// 🛡️ 4. BLINDAJE CSRF (Equivalente a tu ViewStateUserKey en OnInit)
// Ya tienes la función generate_csrf_token() en tu otro archivo, asegúrate de llamarla
$csrf_token = generate_csrf_token();
?>